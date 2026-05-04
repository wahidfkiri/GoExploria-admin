<?php

namespace Vendor\Cms\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ZipArchive;

class ThemeCDNService
{
    protected $baseUrl;
    protected $apiKey;
    protected $apiSecret;
    protected $timeout;
    protected $retryTimes;
    
    public function __construct()
    {
        $this->baseUrl = rtrim(env('THEME_CDN_URL', 'https://goexploriabusiness.com'), '/');
        $this->apiKey = env('THEME_CDN_API_KEY');
        $this->apiSecret = env('THEME_CDN_API_SECRET');
        $this->timeout = env('THEME_CDN_TIMEOUT', 60); // Longer timeout for theme files
        $this->retryTimes = env('THEME_CDN_RETRY_TIMES', 3);
        
        Log::channel('theme_cdn')->info('Theme CDN Service initialized', [
            'base_url' => $this->baseUrl,
            'has_api_key' => !empty($this->apiKey),
            'has_api_secret' => !empty($this->apiSecret),
            'timeout' => $this->timeout,
            'retry_times' => $this->retryTimes
        ]);
    }
    
    /**
     * Upload a theme file to CDN
     */
    public function upload($file, $path = '', $visibility = 'public')
    {
        $startTime = microtime(true);
        $fileInfo = $this->getFileInfo($file);
        $requestId = (string) Str::uuid();
        
        Log::channel('theme_cdn')->info('Theme CDN Upload Started', [
            'request_id' => $requestId,
            'file_name' => $fileInfo['name'],
            'file_size' => $fileInfo['size'],
            'file_mime' => $fileInfo['mime'],
            'target_path' => $path,
            'visibility' => $visibility,
            'cdn_url' => $this->baseUrl
        ]);
        
        try {
            if (!$this->isConfigured()) {
                Log::channel('theme_cdn')->error('Theme CDN Upload Failed - Configuration Error', [
                    'request_id' => $requestId,
                    'error' => 'Theme CDN not configured. Missing API keys or URL'
                ]);
                
                return [
                    'success' => false,
                    'error' => 'Theme CDN not configured. Please check .env file',
                    'missing' => [
                        'api_key' => empty($this->apiKey),
                        'api_secret' => empty($this->apiSecret),
                        'base_url' => empty($this->baseUrl)
                    ]
                ];
            }

            if ($this->isZipFile($fileInfo['name'])) {
                return $this->uploadZipArchive($file, $path, $visibility, $requestId, $fileInfo, $startTime);
            }
            
            $fileContent = $this->getFileContent($file);
            $fileName = $fileInfo['name'];
            
            if ($fileContent === false) {
                Log::channel('theme_cdn')->error('Theme CDN Upload Failed - Cannot Read File', [
                    'request_id' => $requestId,
                    'file_name' => $fileName
                ]);
                
                return [
                    'success' => false,
                    'error' => 'Cannot read file content'
                ];
            }
            
            Log::channel('theme_cdn')->debug('Theme CDN Upload Request Details', [
                'request_id' => $requestId,
                'file_content_length' => strlen($fileContent),
                'api_endpoint' => $this->baseUrl . '/api/upload'
            ]);
            
            $response = $this->sendUploadRequest($fileContent, $fileName, $path, $visibility);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($response->successful()) {
                $result = $response->json();
                
                Log::channel('theme_cdn')->info('Theme CDN Upload Successful', [
                    'request_id' => $requestId,
                    'file_name' => $fileName,
                    'file_size' => $fileInfo['size'],
                    'duration_ms' => $duration,
                    'cdn_url' => $result['url'] ?? null,
                    'cdn_path' => $result['path'] ?? null
                ]);
                
                return array_merge($result, [
                    'success' => true,
                    'request_id' => $requestId,
                    'duration_ms' => $duration
                ]);
            }
            
            Log::channel('theme_cdn')->error('Theme CDN Upload Failed - HTTP Error', [
                'request_id' => $requestId,
                'file_name' => $fileName,
                'http_status' => $response->status(),
                'response_body' => $response->body()
            ]);
            
            return [
                'success' => false,
                'error' => 'Upload failed with HTTP status: ' . $response->status(),
                'http_status' => $response->status(),
                'response' => $response->json(),
                'request_id' => $requestId,
                'duration_ms' => $duration
            ];
            
        } catch (\Exception $e) {
            Log::channel('theme_cdn')->error('Theme CDN Upload Failed - Exception', [
                'request_id' => $requestId,
                'file_name' => $fileInfo['name'],
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'request_id' => $requestId
            ];
        }
    }
    
    /**
     * Upload an entire directory to CDN
     */
    public function uploadDirectory($sourceDir, $targetPath, $callback = null, $visibility = 'public')
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sourceDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        $uploaded = [];
        $failed = [];
        
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            
            $relativePath = str_replace($sourceDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $cdnFilePath = $targetPath . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
            
            $result = $this->upload($file->getPathname(), dirname($cdnFilePath), $visibility);
            
            if ($result['success'] ?? false) {
                $uploaded[] = $cdnFilePath;
            } else {
                $failed[] = [
                    'path' => $cdnFilePath,
                    'error' => $result['error'] ?? 'Unknown error'
                ];
            }
            
            if ($callback) {
                $callback($relativePath, $result);
            }
        }
        
        return [
            'success' => empty($failed),
            'uploaded' => $uploaded,
            'failed' => $failed,
            'total' => count($uploaded) + count($failed),
            'uploaded_count' => count($uploaded),
            'failed_count' => count($failed)
        ];
    }
    
    /**
     * Delete a theme file from CDN
     */
    public function delete($path)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        Log::channel('theme_cdn')->info('Theme CDN Delete Started', [
            'request_id' => $requestId,
            'path' => $path,
            'cdn_url' => $this->baseUrl
        ]);
        
        try {
            if (!$this->isConfigured()) {
                Log::channel('theme_cdn')->error('Theme CDN Delete Failed - Configuration Error', [
                    'request_id' => $requestId,
                    'path' => $path
                ]);
                
                return [
                    'success' => false,
                    'error' => 'Theme CDN not configured'
                ];
            }
            
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'X-API-Key' => $this->apiKey,
                    'X-API-Secret' => $this->apiSecret,
                ])
                ->delete($this->baseUrl . '/api/file/' . urlencode($path));
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($response->successful()) {
                $result = $response->json();
                
                Log::channel('theme_cdn')->info('Theme CDN Delete Successful', [
                    'request_id' => $requestId,
                    'path' => $path,
                    'duration_ms' => $duration
                ]);
                
                return array_merge($result, [
                    'success' => true,
                    'request_id' => $requestId,
                    'duration_ms' => $duration
                ]);
            }
            
            Log::channel('theme_cdn')->error('Theme CDN Delete Failed - HTTP Error', [
                'request_id' => $requestId,
                'path' => $path,
                'http_status' => $response->status(),
                'response_body' => $response->body()
            ]);
            
            return [
                'success' => false,
                'error' => 'Delete failed with HTTP status: ' . $response->status(),
                'http_status' => $response->status(),
                'request_id' => $requestId,
                'duration_ms' => $duration
            ];
            
        } catch (\Exception $e) {
            Log::channel('theme_cdn')->error('Theme CDN Delete Failed - Exception', [
                'request_id' => $requestId,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'request_id' => $requestId
            ];
        }
    }
    
    /**
     * Get theme file from CDN
     */
    public function getFile($path)
    {
        $startTime = microtime(true);
        $requestId = (string) Str::uuid();
        
        Log::channel('theme_cdn')->debug('Theme CDN Get File Started', [
            'request_id' => $requestId,
            'path' => $path,
            'cdn_url' => $this->baseUrl
        ]);
        
        try {
            $url = $this->baseUrl . '/storage/theme/' . $path;
            
            $response = Http::timeout($this->timeout)
                ->get($url);
            
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            if ($response->successful()) {
                Log::channel('theme_cdn')->debug('Theme CDN Get File Successful', [
                    'request_id' => $requestId,
                    'path' => $path,
                    'duration_ms' => $duration,
                    'content_length' => strlen($response->body())
                ]);
                
                return $response->body();
            }
            
            Log::channel('theme_cdn')->warning('Theme CDN Get File Failed', [
                'request_id' => $requestId,
                'path' => $path,
                'http_status' => $response->status()
            ]);
            
            return null;
            
        } catch (\Exception $e) {
            Log::channel('theme_cdn')->error('Theme CDN Get File Failed - Exception', [
                'request_id' => $requestId,
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            
            return null;
        }
    }
    
    /**
     * Check if theme exists on CDN
     */
    public function exists($path)
    {
        $content = $this->getFile($path);
        return !is_null($content);
    }
    
    /**
     * Test connection to theme CDN
     */
    public function testConnection(): array
    {
        $requestId = (string) Str::uuid();
        
        try {
            $startTime = microtime(true);
            $response = Http::timeout(10)->get($this->baseUrl . '/api/health');
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            
            $result = [
                'success' => $response->successful(),
                'status' => $response->status(),
                'duration_ms' => $duration,
                'cdn_url' => $this->baseUrl,
                'configured' => $this->isConfigured(),
                'request_id' => $requestId
            ];
            
            Log::channel('theme_cdn')->info('Theme CDN Connection Test Completed', $result);
            
            return $result;
            
        } catch (\Exception $e) {
            Log::channel('theme_cdn')->error('Theme CDN Connection Test Failed', [
                'request_id' => $requestId,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'configured' => $this->isConfigured(),
                'request_id' => $requestId
            ];
        }
    }
    
    /**
     * Check if CDN is properly configured
     */
    public function isConfigured(): bool
    {
        $configured = !empty($this->apiKey) && !empty($this->apiSecret) && !empty($this->baseUrl);
        
        if (!$configured) {
            Log::channel('theme_cdn')->warning('Theme CDN Configuration Incomplete', [
                'has_base_url' => !empty($this->baseUrl),
                'has_api_key' => !empty($this->apiKey),
                'has_api_secret' => !empty($this->apiSecret)
            ]);
        }
        
        return $configured;
    }
    
    /**
     * Get file information
     */
    protected function getFileInfo($file): array
    {
        if ($file instanceof UploadedFile) {
            return [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'type' => 'uploaded_file'
            ];
        }
        
        if (is_string($file) && file_exists($file)) {
            return [
                'name' => basename($file),
                'size' => filesize($file),
                'mime' => mime_content_type($file),
                'type' => 'file_path'
            ];
        }
        
        return [
            'name' => 'unknown',
            'size' => 0,
            'mime' => 'unknown',
            'type' => 'unknown'
        ];
    }
    
    /**
     * Get file content
     */
    protected function getFileContent($file)
    {
        if ($file instanceof UploadedFile) {
            return file_get_contents($file->getRealPath());
        }
        
        if (is_string($file) && file_exists($file)) {
            return file_get_contents($file);
        }
        
        return false;
    }

    protected function sendUploadRequest(string $fileContent, string $fileName, string $path, string $visibility)
    {
        return Http::timeout($this->timeout)
            ->retry($this->retryTimes, 100)
            ->withHeaders([
                'X-API-Key' => $this->apiKey,
                'X-API-Secret' => $this->apiSecret,
            ])
            ->attach('file', $fileContent, $fileName)
            ->post($this->baseUrl . '/api/upload', [
                'path' => $path,
                'visibility' => $visibility,
                'type' => 'theme'
            ]);
    }

    protected function isZipFile(?string $fileName): bool
    {
        if (!$fileName) {
            return false;
        }

        return strtolower((string) pathinfo($fileName, PATHINFO_EXTENSION)) === 'zip';
    }

    protected function uploadZipArchive($file, string $path, string $visibility, string $requestId, array $fileInfo, float $startTime): array
    {
        $zipPath = null;

        if ($file instanceof UploadedFile) {
            $zipPath = $file->getRealPath();
        } elseif (is_string($file) && file_exists($file)) {
            $zipPath = $file;
        }

        if (!$zipPath || !file_exists($zipPath)) {
            return [
                'success' => false,
                'error' => 'ZIP file path is invalid',
                'request_id' => $requestId,
            ];
        }

        $tempDir = storage_path('app/temp/theme_cdn_zip_' . Str::uuid());
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zip = new ZipArchive();
        $openResult = $zip->open($zipPath);

        if ($openResult !== true) {
            $this->deleteDirectory($tempDir);

            return [
                'success' => false,
                'error' => 'Unable to open ZIP file (code: ' . $openResult . ')',
                'request_id' => $requestId,
            ];
        }

        $writtenCount = 0;

        try {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entryName = (string) $zip->getNameIndex($i);
                if ($entryName === '' || str_ends_with($entryName, '/')) {
                    continue;
                }

                $normalizedEntryPath = $this->normalizeZipEntryPath($entryName);
                if ($normalizedEntryPath === null) {
                    continue;
                }

                $entryContent = $zip->getFromIndex($i);
                if ($entryContent === false) {
                    continue;
                }

                $targetFilePath = $tempDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $normalizedEntryPath);
                $targetDir = dirname($targetFilePath);
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                file_put_contents($targetFilePath, $entryContent);
                $writtenCount++;
            }
        } finally {
            $zip->close();
        }

        if ($writtenCount === 0) {
            $this->deleteDirectory($tempDir);

            return [
                'success' => false,
                'error' => 'ZIP has no valid files to extract',
                'request_id' => $requestId,
            ];
        }

        $uploadResult = $this->uploadDirectory($tempDir, $path, null, $visibility);
        $duration = round((microtime(true) - $startTime) * 1000, 2);

        $this->deleteDirectory($tempDir);

        if (!($uploadResult['success'] ?? false)) {
            Log::channel('theme_cdn')->error('Theme CDN ZIP Upload Failed', [
                'request_id' => $requestId,
                'file_name' => $fileInfo['name'] ?? null,
                'uploaded_count' => $uploadResult['uploaded_count'] ?? 0,
                'failed_count' => $uploadResult['failed_count'] ?? 0,
            ]);

            return [
                'success' => false,
                'error' => 'ZIP extracted but one or more files failed to upload',
                'request_id' => $requestId,
                'is_zip' => true,
                'uploaded_count' => $uploadResult['uploaded_count'] ?? 0,
                'failed_count' => $uploadResult['failed_count'] ?? 0,
                'failed' => $uploadResult['failed'] ?? [],
                'duration_ms' => $duration,
            ];
        }

        Log::channel('theme_cdn')->info('Theme CDN ZIP Upload Successful', [
            'request_id' => $requestId,
            'file_name' => $fileInfo['name'] ?? null,
            'uploaded_count' => $uploadResult['uploaded_count'] ?? 0,
            'duration_ms' => $duration,
        ]);

        return [
            'success' => true,
            'request_id' => $requestId,
            'is_zip' => true,
            'extracted' => true,
            'base_path' => trim($path, '/'),
            'zip_original_name' => $fileInfo['name'] ?? null,
            'uploaded_count' => $uploadResult['uploaded_count'] ?? 0,
            'failed_count' => $uploadResult['failed_count'] ?? 0,
            'uploaded' => $uploadResult['uploaded'] ?? [],
            'failed' => $uploadResult['failed'] ?? [],
            'duration_ms' => $duration,
        ];
    }

    protected function deleteDirectory(string $dir): bool
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return @unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return @rmdir($dir);
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

            $safeSegment = preg_replace('/[^A-Za-z0-9._-]/', '-', $segment) ?: '';
            $safeSegment = trim($safeSegment, '-');

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
}
