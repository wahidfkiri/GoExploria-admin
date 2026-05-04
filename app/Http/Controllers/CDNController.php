<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class CDNController extends Controller
{
    protected $apiKey;
    protected $apiSecret;
    
    public function __construct()
    {
        $this->apiKey = env('API_KEY');
        $this->apiSecret = env('API_SECRET');
        
        Log::channel('cdn_upload')->info('CDN Controller initialized', [
            'has_api_key' => !empty($this->apiKey),
            'has_api_secret' => !empty($this->apiSecret),
            'api_key_preview' => $this->apiKey ? substr($this->apiKey, 0, 10) . '...' : null
        ]);
    }
    
    /**
     * Vérifier l'authentification API
     */
    protected function authenticate(Request $request)
    {
        $apiKey = $request->header('X-API-Key');
        $apiSecret = $request->header('X-API-Secret');
        
        Log::channel('cdn_upload')->debug('Authentication attempt', [
            'provided_key' => $apiKey ? substr($apiKey, 0, 10) . '...' : null,
            'provided_secret' => $apiSecret ? substr($apiSecret, 0, 10) . '...' : null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        if (!$apiKey || !$apiSecret) {
            Log::channel('cdn_upload')->warning('Authentication failed - Missing credentials', [
                'ip' => $request->ip(),
                'has_key' => !empty($apiKey),
                'has_secret' => !empty($apiSecret)
            ]);
            return false;
        }
        
        if ($apiKey !== $this->apiKey || $apiSecret !== $this->apiSecret) {
            Log::channel('cdn_upload')->warning('Authentication failed - Invalid credentials', [
                'ip' => $request->ip(),
                'provided_key' => substr($apiKey, 0, 10) . '...',
                'expected_key' => $this->apiKey ? substr($this->apiKey, 0, 10) . '...' : null
            ]);
            return false;
        }
        
        Log::channel('cdn_upload')->info('Authentication successful', [
            'ip' => $request->ip()
        ]);
        
        return true;
    }
    
    /**
     * Upload de fichier
     */
    public function upload(Request $request)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        // Vérifier l'authentification
        if (!$this->authenticate($request)) {
            Log::channel('cdn_upload')->error('Upload rejected - Authentication failed', [
                'request_id' => $requestId,
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'request_id' => $requestId
            ], 401);
        }
        
        Log::channel('cdn_upload')->info('Upload request received', [
            'request_id' => $requestId,
            'has_file' => $request->hasFile('file'),
            'path' => $request->input('path', ''),
            'visibility' => $request->input('visibility', 'public'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        try {
            // Validation
            $validator = validator($request->all(), [
                'file' => 'required|file|max:1002400', // 100MB max
                'path' => 'nullable|string|max:255',
                'visibility' => 'nullable|in:public,private'
            ]);
            
            if ($validator->fails()) {
                Log::channel('cdn_upload')->warning('Upload validation failed', [
                    'request_id' => $requestId,
                    'errors' => $validator->errors()->toArray()
                ]);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'request_id' => $requestId
                ], 422);
            }
            
            $file = $request->file('file');
            $path = $request->input('path', '');
            $visibility = $request->input('visibility', 'public');
            
            $originalName = $file->getClientOriginalName();
            $originalExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $fileMime = $file->getMimeType();
            
            Log::channel('cdn_upload')->debug('File details', [
                'request_id' => $requestId,
                'original_name' => $originalName,
                'extension' => $originalExtension,
                'size' => $fileSize,
                'mime' => $fileMime,
                'temp_path' => $file->getPathname()
            ]);

            $isZip = strtolower((string) $originalExtension) === 'zip';
            if ($isZip) {
                $zipBasePath = $this->resolveZipBasePath($path);
                $zipResult = $this->extractZipAndStore($file, $zipBasePath, $visibility, $requestId);
                $duration = round((microtime(true) - $startTime) * 1000, 2);

                Log::channel('cdn_upload')->info('ZIP upload extracted successfully', [
                    'request_id' => $requestId,
                    'requested_path' => trim($path, '/'),
                    'zip_base_path' => $zipBasePath,
                    'extracted_count' => $zipResult['extracted_count'],
                    'skipped_count' => $zipResult['skipped_count'],
                    'duration_ms' => $duration
                ]);

                return response()->json([
                    'success' => true,
                    'request_id' => $requestId,
                    'is_zip' => true,
                    'extracted' => true,
                    'requested_path' => trim($path, '/'),
                    'base_path' => $zipBasePath,
                    'zip_original_name' => $originalName,
                    'zip_size' => $fileSize,
                    'extracted_count' => $zipResult['extracted_count'],
                    'skipped_count' => $zipResult['skipped_count'],
                    'files' => $zipResult['files'],
                    'duration_ms' => $duration
                ], 201);
            }
            
            // Générer un nom unique
            $filename = $this->resolveUniqueFilename($path, $originalName, $originalExtension);
            $fullPath = trim($path . '/' . $filename, '/');
            
            Log::channel('cdn_upload')->info('Storing file', [
                'request_id' => $requestId,
                'full_path' => $fullPath,
                'filename' => $filename,
                'visibility' => $visibility
            ]);
            
            // Stocker le fichier
            $stored = Storage::disk('cdn')->put($fullPath, file_get_contents($file), $visibility);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($stored) {
                $fileUrl = Storage::disk('cdn')->url($fullPath);
                
                Log::channel('cdn_upload')->info('Upload successful', [
                    'request_id' => $requestId,
                    'path' => $fullPath,
                    'url' => $fileUrl,
                    'size' => $fileSize,
                    'duration_ms' => $duration,
                    'original_name' => $originalName
                ]);
                
                return response()->json([
                    'success' => true,
                    'request_id' => $requestId,
                    'path' => $fullPath,
                    'url' => $fileUrl,
                    'size' => $fileSize,
                    'mime_type' => $fileMime,
                    'filename' => $filename,
                    'original_name' => $originalName,
                    'duration_ms' => $duration
                ], 201);
            }
            
            Log::channel('cdn_upload')->error('Upload failed - Storage error', [
                'request_id' => $requestId,
                'full_path' => $fullPath,
                'duration_ms' => $duration
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Upload failed - Storage error',
                'request_id' => $requestId
            ], 500);
            
        } catch (\Exception $e) {
            Log::channel('cdn_upload')->critical('Upload exception', [
                'request_id' => $requestId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Internal server error: ' . $e->getMessage(),
                'request_id' => $requestId
            ], 500);
        }
    }
    
    /**
     * Upload multiple
     */
    public function uploadMultiple(Request $request)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        // Vérifier l'authentification
        if (!$this->authenticate($request)) {
            Log::channel('cdn_upload')->error('Multiple upload rejected - Authentication failed', [
                'request_id' => $requestId,
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'request_id' => $requestId
            ], 401);
        }
        
        Log::channel('cdn_upload')->info('Multiple upload request received', [
            'request_id' => $requestId,
            'files_count' => count($request->file('files', [])),
            'path' => $request->input('path', ''),
            'ip' => $request->ip()
        ]);
        
        try {
            $validator = validator($request->all(), [
                'files.*' => 'required|file|max:102400',
                'path' => 'nullable|string'
            ]);
            
            if ($validator->fails()) {
                Log::channel('cdn_upload')->warning('Multiple upload validation failed', [
                    'request_id' => $requestId,
                    'errors' => $validator->errors()->toArray()
                ]);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'request_id' => $requestId
                ], 422);
            }
            
            $uploaded = [];
            $errors = [];
            $totalSize = 0;
            
            foreach ($request->file('files') as $index => $file) {
                try {
                    $path = $request->input('path', '');
                    $extension = strtolower((string) $file->getClientOriginalExtension());

                    if ($extension === 'zip') {
                        $zipBasePath = $this->resolveZipBasePath($path);
                        $zipResult = $this->extractZipAndStore($file, $zipBasePath, 'public', $requestId);
                        $fileSize = $file->getSize();
                        $totalSize += $fileSize;

                        $uploaded[] = [
                            'path' => $zipBasePath,
                            'url' => null,
                            'original_name' => $file->getClientOriginalName(),
                            'size' => $fileSize,
                            'mime_type' => $file->getMimeType(),
                            'is_zip' => true,
                            'requested_path' => trim($path, '/'),
                            'base_path' => $zipBasePath,
                            'extracted_count' => $zipResult['extracted_count'],
                            'skipped_count' => $zipResult['skipped_count'],
                            'files' => $zipResult['files'],
                        ];

                        continue;
                    }

                    $filename = $this->resolveUniqueFilename(
                        $path,
                        $file->getClientOriginalName(),
                        $file->getClientOriginalExtension()
                    );
                    $fullPath = trim($path . '/' . $filename, '/');
                    
                    $fileSize = $file->getSize();
                    $totalSize += $fileSize;
                    
                    Log::channel('cdn_upload')->debug('Processing file in multiple upload', [
                        'request_id' => $requestId,
                        'index' => $index,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $fileSize,
                        'target_path' => $fullPath
                    ]);
                    
                    Storage::disk('cdn')->put($fullPath, file_get_contents($file));
                    
                    $uploaded[] = [
                        'path' => $fullPath,
                        'url' => Storage::disk('cdn')->url($fullPath),
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $fileSize,
                        'mime_type' => $file->getMimeType()
                    ];
                    
                } catch (\Exception $e) {
                    Log::channel('cdn_upload')->error('File upload failed in multiple upload', [
                        'request_id' => $requestId,
                        'index' => $index,
                        'file' => $file->getClientOriginalName(),
                        'error' => $e->getMessage()
                    ]);
                    
                    $errors[] = [
                        'file' => $file->getClientOriginalName(),
                        'error' => $e->getMessage()
                    ];
                }
            }
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            Log::channel('cdn_upload')->info('Multiple upload completed', [
                'request_id' => $requestId,
                'total_files' => count($request->file('files')),
                'uploaded_count' => count($uploaded),
                'failed_count' => count($errors),
                'total_size' => $totalSize,
                'duration_ms' => $duration
            ]);
            
            return response()->json([
                'success' => count($uploaded) > 0,
                'request_id' => $requestId,
                'total' => count($request->file('files')),
                'uploaded_count' => count($uploaded),
                'failed_count' => count($errors),
                'uploaded' => $uploaded,
                'errors' => $errors,
                'duration_ms' => $duration
            ], count($errors) > 0 ? 207 : 200); // 207 Multi-Status
            
        } catch (\Exception $e) {
            Log::channel('cdn_upload')->critical('Multiple upload exception', [
                'request_id' => $requestId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'request_id' => $requestId
            ], 500);
        }
    }
    
    /**
     * Récupérer un fichier
     */
    public function getFile(Request $request, $path)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        Log::channel('cdn_upload')->info('Get file request', [
            'request_id' => $requestId,
            'path' => $path,
            'ip' => $request->ip()
        ]);
        
        try {
            if (!Storage::disk('cdn')->exists($path)) {
                Log::channel('cdn_upload')->warning('File not found', [
                    'request_id' => $requestId,
                    'path' => $path
                ]);
                
                return response()->json([
                    'error' => 'File not found',
                    'request_id' => $requestId
                ], 404);
            }
            
            $file = Storage::disk('cdn')->get($path);
            $mime = Storage::disk('cdn')->mimeType($path);
            $size = Storage::disk('cdn')->size($path);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            Log::channel('cdn_upload')->info('File retrieved successfully', [
                'request_id' => $requestId,
                'path' => $path,
                'size' => $size,
                'mime' => $mime,
                'duration_ms' => $duration
            ]);
            
            return response($file)
                ->header('Content-Type', $mime)
                ->header('Content-Length', $size)
                ->header('X-Request-ID', $requestId);
                
        } catch (\Exception $e) {
            Log::channel('cdn_upload')->error('Get file exception', [
                'request_id' => $requestId,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'error' => 'Internal server error',
                'request_id' => $requestId
            ], 500);
        }
    }
    
    /**
     * Supprimer un fichier
     */
    public function deleteFile(Request $request, $path)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        $path = urldecode($path);
        
        // Vérifier l'authentification
        if (!$this->authenticate($request)) {
            Log::channel('cdn_upload')->error('Delete rejected - Authentication failed', [
                'request_id' => $requestId,
                'path' => $path,
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'request_id' => $requestId
            ], 401);
        }
        
        Log::channel('cdn_upload')->info('Delete request', [
            'request_id' => $requestId,
            'path' => $path,
            'ip' => $request->ip()
        ]);
        
        try {
            if (!Storage::disk('cdn')->exists($path)) {
                Log::channel('cdn_upload')->warning('Delete failed - File not found', [
                    'request_id' => $requestId,
                    'path' => $path
                ]);
                
                return response()->json([
                    'success' => false,
                    'error' => 'File not found',
                    'request_id' => $requestId
                ], 404);
            }
            
            $fileSize = Storage::disk('cdn')->size($path);
            $deleted = Storage::disk('cdn')->delete($path);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($deleted) {
                Log::channel('cdn_upload')->info('File deleted successfully', [
                    'request_id' => $requestId,
                    'path' => $path,
                    'size' => $fileSize,
                    'duration_ms' => $duration
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'File deleted',
                    'request_id' => $requestId,
                    'path' => $path,
                    'duration_ms' => $duration
                ]);
            }
            
            Log::channel('cdn_upload')->error('Delete failed - Storage error', [
                'request_id' => $requestId,
                'path' => $path
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Delete failed',
                'request_id' => $requestId
            ], 500);
            
        } catch (\Exception $e) {
            Log::channel('cdn_upload')->error('Delete exception', [
                'request_id' => $requestId,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'request_id' => $requestId
            ], 500);
        }
    }
    
    /**
     * Lister les fichiers
     */
    public function listFiles(Request $request)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        // Vérifier l'authentification
        if (!$this->authenticate($request)) {
            Log::channel('cdn_upload')->error('List files rejected - Authentication failed', [
                'request_id' => $requestId,
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'request_id' => $requestId
            ], 401);
        }
        
        $directory = $request->input('directory', '');
        
        Log::channel('cdn_upload')->info('List files request', [
            'request_id' => $requestId,
            'directory' => $directory,
            'ip' => $request->ip()
        ]);
        
        try {
            $files = Storage::disk('cdn')->files($directory);
            
            $fileDetails = array_map(function($file) {
                return [
                    'path' => $file,
                    'url' => Storage::disk('cdn')->url($file),
                    'size' => Storage::disk('cdn')->size($file),
                    'last_modified' => Storage::disk('cdn')->lastModified($file),
                    'mime_type' => Storage::disk('cdn')->mimeType($file)
                ];
            }, $files);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            Log::channel('cdn_upload')->info('Files listed successfully', [
                'request_id' => $requestId,
                'directory' => $directory,
                'count' => count($fileDetails),
                'duration_ms' => $duration
            ]);
            
            return response()->json([
                'success' => true,
                'request_id' => $requestId,
                'directory' => $directory,
                'count' => count($fileDetails),
                'files' => $fileDetails,
                'duration_ms' => $duration
            ]);
            
        } catch (\Exception $e) {
            Log::channel('cdn_upload')->error('List files exception', [
                'request_id' => $requestId,
                'directory' => $directory,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'request_id' => $requestId
            ], 500);
        }
    }
    
    /**
     * Générer URL temporaire
     */
    public function temporaryUrl(Request $request, $path)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        // Vérifier l'authentification
        if (!$this->authenticate($request)) {
            Log::channel('cdn_upload')->error('Temporary URL rejected - Authentication failed', [
                'request_id' => $requestId,
                'path' => $path,
                'ip' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
                'request_id' => $requestId
            ], 401);
        }
        
        $expiration = $request->input('expiration', now()->addMinutes(30));
        
        Log::channel('cdn_upload')->info('Temporary URL request', [
            'request_id' => $requestId,
            'path' => $path,
            'expiration' => $expiration,
            'ip' => $request->ip()
        ]);
        
        try {
            if (!Storage::disk('cdn')->exists($path)) {
                Log::channel('cdn_upload')->warning('Temporary URL failed - File not found', [
                    'request_id' => $requestId,
                    'path' => $path
                ]);
                
                return response()->json([
                    'success' => false,
                    'error' => 'File not found',
                    'request_id' => $requestId
                ], 404);
            }
            
            $url = Storage::disk('cdn')->temporaryUrl($path, $expiration);
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            Log::channel('cdn_upload')->info('Temporary URL generated', [
                'request_id' => $requestId,
                'path' => $path,
                'expires_at' => $expiration,
                'duration_ms' => $duration
            ]);
            
            return response()->json([
                'success' => true,
                'request_id' => $requestId,
                'url' => $url,
                'expires_at' => $expiration,
                'duration_ms' => $duration
            ]);
            
        } catch (\Exception $e) {
            Log::channel('cdn_upload')->error('Temporary URL exception', [
                'request_id' => $requestId,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Internal server error',
                'request_id' => $requestId
            ], 500);
        }
    }

    protected function resolveZipBasePath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path), '/');
        if ($path === '') {
            return '';
        }

        $segments = array_values(array_filter(explode('/', $path), static fn ($s) => $s !== ''));

        // For themes: keep only cms/themes/{etablissementId}
        if (count($segments) >= 3 && $segments[0] === 'cms' && $segments[1] === 'themes') {
            return implode('/', array_slice($segments, 0, 3));
        }

        return $path;
    }

    protected function extractZipAndStore(UploadedFile $zipFile, string $basePath, string $visibility, string $requestId): array
    {
        $zip = new ZipArchive();
        $zipPath = $zipFile->getRealPath();
        $openResult = $zip->open($zipPath);

        if ($openResult !== true) {
            throw new \RuntimeException('Impossible d\'ouvrir le fichier ZIP (code: ' . $openResult . ')');
        }

        $storedFiles = [];
        $skippedCount = 0;

        try {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entryName = (string) $zip->getNameIndex($i);

                if ($entryName === '' || str_ends_with($entryName, '/')) {
                    continue;
                }

                $normalizedEntryPath = $this->normalizeZipEntryPath($entryName);
                if ($normalizedEntryPath === null) {
                    $skippedCount++;
                    continue;
                }

                $normalizedEntryPath = $this->normalizeThemeStructurePath($normalizedEntryPath, $basePath);
                if ($normalizedEntryPath === null) {
                    $skippedCount++;
                    continue;
                }

                $entryContent = $zip->getFromIndex($i);
                if ($entryContent === false) {
                    $skippedCount++;
                    continue;
                }

                $targetPath = trim($basePath . '/' . $normalizedEntryPath, '/');
                Storage::disk('cdn')->put($targetPath, $entryContent, $visibility);

                $storedFiles[] = [
                    'path' => $targetPath,
                    'url' => Storage::disk('cdn')->url($targetPath),
                    'size' => strlen($entryContent),
                    'original_name' => $entryName,
                ];
            }
        } finally {
            $zip->close();
        }

        if (count($storedFiles) === 0) {
            Log::channel('cdn_upload')->warning('ZIP extraction produced no files', [
                'request_id' => $requestId,
                'zip_name' => $zipFile->getClientOriginalName(),
                'base_path' => $basePath,
                'skipped_count' => $skippedCount,
            ]);

            throw new \RuntimeException('Aucun fichier valide extrait du ZIP');
        }

        return [
            'extracted_count' => count($storedFiles),
            'skipped_count' => $skippedCount,
            'files' => $storedFiles,
        ];
    }

    protected function normalizeZipEntryPath(string $entryName): ?string
    {
        $entryName = trim(str_replace('\\', '/', $entryName), '/');
        if ($entryName === '') {
            return null;
        }

        $segments = explode('/', $entryName);
        $safeSegments = [];

        foreach ($segments as $segment) {
            if ($segment === '' || $segment === '.') {
                continue;
            }

            if ($segment === '..') {
                return null;
            }

            $safeSegment = $this->sanitizeFilename($segment);
            if ($safeSegment === '') {
                continue;
            }

            $safeSegments[] = $safeSegment;
        }

        if (empty($safeSegments)) {
            return null;
        }

        return implode('/', $safeSegments);
    }

    protected function normalizeThemeStructurePath(string $entryPath, string $basePath): ?string
    {
        $basePath = trim(str_replace('\\', '/', $basePath), '/');
        $entryPath = trim(str_replace('\\', '/', $entryPath), '/');

        // Ignore temporary helper files sometimes present in generated zips
        if (preg_match('/\.file$/i', $entryPath)) {
            return null;
        }

        // For theme uploads, auto-place known files into expected folders.
        if (!preg_match('#(^|/)cms/themes/\d+(/|$)#', $basePath)) {
            return $entryPath;
        }
        
        $segments = explode('/', $entryPath);
        $first = strtolower($segments[0] ?? '');

        // Already structured as expected
        if (in_array($first, ['assets', 'partials', 'pages'], true)) {
            return $entryPath;
        }

        // Flat file at root
        if (count($segments) === 1) {
            return $this->mapThemeRootFile($segments[0]);
        }

        // Wrapper folder + flat file: theme-website/header.blade.php
        if (count($segments) === 2) {
            $wrapper = $segments[0];
            $mapped = $this->mapThemeRootFile($segments[1]);
            if ($mapped !== $segments[1]) {
                return $wrapper . '/' . $mapped;
            }
        }

        return $entryPath;
    }

    protected function mapThemeRootFile(string $fileName): string
    {
        $name = strtolower($fileName);

        if (in_array($name, ['header.blade.php', 'footer.blade.php'], true)) {
            return 'partials/' . $fileName;
        }

        if (in_array($name, ['home.blade.php', 'page.blade.php'], true)) {
            return 'pages/' . $fileName;
        }

        if (in_array($name, ['main.js', 'theme.js'], true)) {
            return 'assets/js/' . $fileName;
        }

        if (in_array($name, ['style.css', 'responsive.css', 'theme.css'], true)) {
            return 'assets/css/' . $fileName;
        }

        return $fileName;
    }

    protected function resolveUniqueFilename(string $path, ?string $originalName, ?string $fallbackExtension = null): string
    {
        $path = trim($path, '/');
        $originalName = (string) ($originalName ?? '');
        $fallbackExtension = strtolower((string) ($fallbackExtension ?? ''));

        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = strtolower((string) pathinfo($originalName, PATHINFO_EXTENSION));

        if ($baseName === '') {
            $baseName = 'file';
        }

        if ($extension === '' && $fallbackExtension !== '') {
            $extension = ltrim($fallbackExtension, '.');
        }

        $baseName = $this->sanitizeFilename($baseName);
        $extension = $this->sanitizeFilename($extension);

        $candidate = $extension !== '' ? ($baseName . '.' . $extension) : $baseName;
        $candidatePath = trim($path . '/' . $candidate, '/');

        if (!Storage::disk('cdn')->exists($candidatePath)) {
            return $candidate;
        }

        $counter = 1;
        while ($counter <= 10000) {
            $withSuffix = $extension !== ''
                ? sprintf('%s-%d.%s', $baseName, $counter, $extension)
                : sprintf('%s-%d', $baseName, $counter);

            $withSuffixPath = trim($path . '/' . $withSuffix, '/');
            if (!Storage::disk('cdn')->exists($withSuffixPath)) {
                return $withSuffix;
            }

            $counter++;
        }

        return ($extension !== '')
            ? sprintf('%s-%s.%s', $baseName, Str::lower((string) Str::uuid()), $extension)
            : sprintf('%s-%s', $baseName, Str::lower((string) Str::uuid()));
    }

    protected function sanitizeFilename(string $value): string
    {
        $value = preg_replace('/[^A-Za-z0-9._-]/', '-', $value) ?? '';
        $value = trim($value, '-._');

        return $value !== '' ? $value : 'file';
    }
    
    /**
     * Health check endpoint
     */
    public function health(Request $request)
    {
        $requestId = (string) Str::uuid();
        
        Log::channel('cdn_upload')->info('Health check', [
            'request_id' => $requestId,
            'ip' => $request->ip()
        ]);
        
        return response()->json([
            'success' => true,
            'request_id' => $requestId,
            'status' => 'healthy',
            'timestamp' => now(),
            'version' => '1.0.0'
        ]);
    }
}
