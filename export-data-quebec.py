#!/usr/bin/env python3
# -*- coding: utf-8 -*-

"""
Script d'extraction complète des pages régions Bonjour Québec
Extrait: texte, médias, liens, données structurées, métadonnées
URL valide: /ou-aller/regions-du-quebec/{slug}
"""

import json
import csv
import argparse
import sys
import urllib.request
import urllib.error
import time
import re
from typing import List, Dict, Optional, Any
from bs4 import BeautifulSoup
import html

class BonjourQuebecContentExtractor:
    """Extracteur complet de contenu Bonjour Québec"""
    
    BASE_URL = "https://www.bonjourquebec.com/fr-ca"
    
    # Les 17 régions officielles
    REGIONS = {
        "bas-saint-laurent": "Bas-Saint-Laurent",
        "saguenay-lac-saint-jean": "Saguenay–Lac-Saint-Jean",
        "capitale-nationale": "Capitale-Nationale",
        "mauricie": "Mauricie",
        "estrie": "Estrie",
        "montreal": "Montréal",
        "outaouais": "Outaouais",
        "abitibi-temiscamingue": "Abitibi-Témiscamingue",
        "cote-nord": "Côte-Nord",
        "nord-du-quebec": "Nord-du-Québec",
        "gaspesie": "Gaspésie–Îles-de-la-Madeleine",
        "chaudiere-appalaches": "Chaudière-Appalaches",
        "laval": "Laval",
        "lanaudiere": "Lanaudière",
        "laurentides": "Laurentides",
        "monteregie": "Montérégie",
        "centre-du-quebec": "Centre-du-Québec"
    }
    
    def __init__(self):
        self.data = []
        self.errors = []
        self.user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        
    def fetch_page(self, url: str) -> Optional[str]:
        """Récupère le contenu HTML d'une page"""
        try:
            req = urllib.request.Request(
                url,
                headers={
                    'User-Agent': self.user_agent,
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language': 'fr-CA,fr;q=0.9,en-US;q=0.8,en;q=0.7'
                }
            )
            
            with urllib.request.urlopen(req, timeout=30) as response:
                content = response.read().decode('utf-8', errors='ignore')
                return content
                
        except Exception as e:
            print(f"   ❌ Erreur: {e}")
            self.errors.append(str(e))
            return None
    
    def extract_metadata(self, soup: BeautifulSoup, url: str) -> Dict:
        """Extrait les métadonnées de la page"""
        metadata = {
            'url': url,
            'title': '',
            'description': '',
            'keywords': '',
            'language': 'fr-CA',
            'canonical': '',
            'robots': '',
            'og_title': '',
            'og_description': '',
            'og_image': '',
            'og_type': '',
            'twitter_card': '',
            'twitter_title': '',
            'twitter_description': '',
            'twitter_image': '',
            'json_ld': []
        }
        
        # Title
        title_tag = soup.find('title')
        if title_tag:
            metadata['title'] = title_tag.get_text(strip=True)
        
        # Meta tags
        meta_tags = soup.find_all('meta')
        for meta in meta_tags:
            name = meta.get('name', '').lower()
            prop = meta.get('property', '').lower()
            content = meta.get('content', '')
            
            if name == 'description':
                metadata['description'] = content
            elif name == 'keywords':
                metadata['keywords'] = content
            elif name == 'robots':
                metadata['robots'] = content
            
            # Open Graph
            if prop == 'og:title':
                metadata['og_title'] = content
            elif prop == 'og:description':
                metadata['og_description'] = content
            elif prop == 'og:image':
                metadata['og_image'] = content
            elif prop == 'og:type':
                metadata['og_type'] = content
            
            # Twitter Card
            if name == 'twitter:card':
                metadata['twitter_card'] = content
            elif name == 'twitter:title':
                metadata['twitter_title'] = content
            elif name == 'twitter:description':
                metadata['twitter_description'] = content
            elif name == 'twitter:image':
                metadata['twitter_image'] = content
        
        # Canonical
        canonical_tag = soup.find('link', {'rel': 'canonical'})
        if canonical_tag and canonical_tag.get('href'):
            metadata['canonical'] = canonical_tag.get('href')
        
        # JSON-LD (données structurées)
        json_ld_tags = soup.find_all('script', {'type': 'application/ld+json'})
        for tag in json_ld_tags:
            try:
                json_data = json.loads(tag.string)
                metadata['json_ld'].append(json_data)
            except:
                pass
        
        return metadata
    
    def extract_content(self, soup: BeautifulSoup) -> Dict:
        """Extrait le contenu principal de la page"""
        content = {
            'headings': [],
            'paragraphs': [],
            'lists': [],
            'quotes': [],
            'tables': [],
            'structured_content': []
        }
        
        # Headings (h1, h2, h3, h4, h5, h6)
        for i in range(1, 7):
            headings = soup.find_all(f'h{i}')
            for h in headings:
                text = h.get_text(strip=True)
                if text:
                    content['headings'].append({
                        'level': i,
                        'text': text,
                        'id': h.get('id', ''),
                        'class': ' '.join(h.get('class', []))
                    })
        
        # Paragraphs
        paragraphs = soup.find_all('p')
        for p in paragraphs:
            text = p.get_text(strip=True)
            if len(text) > 20:  # Ignorer les petits paragraphes
                content['paragraphs'].append({
                    'text': text,
                    'class': ' '.join(p.get('class', []))
                })
        
        # Lists
        for list_type in ['ul', 'ol']:
            lists = soup.find_all(list_type)
            for lst in lists:
                items = []
                for li in lst.find_all('li'):
                    item_text = li.get_text(strip=True)
                    if item_text:
                        items.append(item_text)
                if items:
                    content['lists'].append({
                        'type': 'ul' if list_type == 'ul' else 'ol',
                        'items': items
                    })
        
        # Blockquotes
        quotes = soup.find_all('blockquote')
        for quote in quotes:
            text = quote.get_text(strip=True)
            if text:
                content['quotes'].append(text)
        
        # Tables
        tables = soup.find_all('table')
        for table in tables:
            table_data = []
            rows = table.find_all('tr')
            for row in rows:
                row_data = []
                for cell in row.find_all(['td', 'th']):
                    row_data.append(cell.get_text(strip=True))
                if row_data:
                    table_data.append(row_data)
            if table_data:
                content['tables'].append(table_data)
        
        # Zones de contenu structuré (cards, sections)
        content_sections = soup.find_all(['article', 'section', 'div'], 
                                        class_=re.compile(r'content|section|card|block|item|component'))
        for section in content_sections[:20]:  # Limiter pour éviter trop de données
            section_text = section.get_text(strip=True)
            if len(section_text) > 50:
                content['structured_content'].append({
                    'class': ' '.join(section.get('class', [])),
                    'text': section_text[:500] + '...' if len(section_text) > 500 else section_text,
                    'html': str(section)[:500] + '...' if len(str(section)) > 500 else str(section)
                })
        
        return content
    
    def extract_media(self, soup: BeautifulSoup) -> Dict:
        """Extrait les médias de la page"""
        media = {
            'images': [],
            'videos': [],
            'embeds': [],
            'downloads': []
        }
        
        # Images
        images = soup.find_all('img')
        for img in images:
            src = img.get('src') or img.get('data-src') or ''
            if src:
                # Compléter les URLs relatives
                if src.startswith('/'):
                    src = self.BASE_URL + src
                elif not src.startswith('http'):
                    src = self.BASE_URL + '/' + src
                
                media['images'].append({
                    'src': src,
                    'alt': img.get('alt', ''),
                    'title': img.get('title', ''),
                    'width': img.get('width', ''),
                    'height': img.get('height', ''),
                    'loading': img.get('loading', '')
                })
        
        # Vidéos (YouTube, Vimeo, etc.)
        # iFrames
        iframes = soup.find_all('iframe')
        for iframe in iframes:
            src = iframe.get('src', '')
            if src:
                media['videos'].append({
                    'src': src,
                    'title': iframe.get('title', ''),
                    'width': iframe.get('width', ''),
                    'height': iframe.get('height', '')
                })
        
        # Embeds (div avec data-embed)
        embeds = soup.find_all(attrs={'data-embed': True})
        for embed in embeds:
            media['embeds'].append({
                'type': embed.get('data-embed', ''),
                'content': str(embed)[:200] + '...'
            })
        
        # Téléchargements (PDF, etc.)
        downloads = soup.find_all('a', href=re.compile(r'\.(pdf|doc|docx|zip|rar|mp3|mp4)$', re.I))
        for dl in downloads:
            href = dl.get('href', '')
            if href:
                if href.startswith('/'):
                    href = self.BASE_URL + href
                media['downloads'].append({
                    'url': href,
                    'text': dl.get_text(strip=True),
                    'title': dl.get('title', '')
                })
        
        return media
    
    def extract_links(self, soup: BeautifulSoup, url: str) -> Dict:
        """Extrait les liens de la page"""
        links = {
            'internal': [],
            'external': [],
            'social': [],
            'navigation': [],
            'related': []
        }
        
        all_links = soup.find_all('a', href=True)
        
        for a in all_links:
            href = a.get('href')
            text = a.get_text(strip=True)
            title = a.get('title', '')
            rel = a.get('rel', [])
            
            if not href or href.startswith('#') or href.startswith('javascript:'):
                continue
            
            # Compléter l'URL
            if href.startswith('/'):
                full_url = self.BASE_URL + href
            elif not href.startswith('http'):
                full_url = self.BASE_URL + '/' + href
            else:
                full_url = href
            
            # Catégoriser
            link_data = {
                'url': full_url,
                'text': text[:100] if text else '',
                'title': title
            }
            
            # Navigation
            if 'nav' in str(a.parents).lower() or a.find_parent('nav'):
                links['navigation'].append(link_data)
            
            # Social
            elif 'social' in str(a.parents).lower() or 'facebook' in href or 'twitter' in href or 'instagram' in href:
                links['social'].append(link_data)
            
            # Interne vs Externe
            elif 'bonjourquebec.com' in full_url:
                links['internal'].append(link_data)
            else:
                links['external'].append(link_data)
            
            # Liens liés (related)
            if 'related' in str(a.parents).lower() or 'suggestion' in str(a.parents).lower():
                links['related'].append(link_data)
        
        # Limiter pour éviter trop de données
        for key in links:
            links[key] = links[key][:50]  # Limiter à 50 liens par catégorie
        
        return links
    
    def extract_region_info(self, soup: BeautifulSoup) -> Dict:
        """Extrait les informations spécifiques à la région"""
        region_info = {
            'description_intro': '',
            'highlights': [],
            'distances': {},
            'fun_facts': [],
            'attractions': [],
            'suggestions': []
        }
        
        # Trouver la description d'introduction
        intro_div = soup.find(['div', 'section'], class_=re.compile(r'intro|hero|banner|description'))
        if intro_div:
            region_info['description_intro'] = intro_div.get_text(strip=True)
        
        # Highlights / Points forts
        highlights = soup.find_all(['div', 'ul'], class_=re.compile(r'highlight|feature|top|important'))
        for h in highlights[:5]:
            text = h.get_text(strip=True)
            if text and len(text) > 20:
                region_info['highlights'].append(text)
        
        # Distances
        distance_elements = soup.find_all(class_=re.compile(r'distance|km|kilom'))
        for elem in distance_elements:
            text = elem.get_text(strip=True)
            if 'km' in text.lower() or 'kilom' in text.lower():
                parts = text.split(':')
                if len(parts) == 2:
                    region_info['distances'][parts[0].strip()] = parts[1].strip()
                else:
                    # Essayer d'extraire ville + distance
                    dist_match = re.search(r'([A-Za-zÀ-ÿ-]+)\s*([0-9]+)\s*km', text)
                    if dist_match:
                        region_info['distances'][dist_match.group(1)] = dist_match.group(2) + ' km'
        
        # Fun facts / Le saviez-vous
        fun_fact_sections = soup.find_all(class_=re.compile(r'fun-fact|saviez|fact|trivia|did-you-know'))
        for section in fun_fact_sections:
            text = section.get_text(strip=True)
            if text:
                region_info['fun_facts'].append(text)
        
        # Attractions
        attraction_sections = soup.find_all(['div', 'section'], class_=re.compile(r'attraction|attrait|sight|place|destination'))
        for section in attraction_sections:
            title = section.find(['h2', 'h3', 'h4'])
            if title:
                attraction = {
                    'title': title.get_text(strip=True),
                    'description': ''
                }
                desc = section.find(['p', 'div'], class_=re.compile(r'desc|text|content'))
                if desc:
                    attraction['description'] = desc.get_text(strip=True)[:500]
                region_info['attractions'].append(attraction)
        
        # Suggestions / Recommendations
        suggestion_sections = soup.find_all(class_=re.compile(r'suggestion|recommend|idea|inspir'))
        for section in suggestion_sections:
            text = section.get_text(strip=True)
            if text and len(text) > 50:
                region_info['suggestions'].append(text[:200])
        
        return region_info
    
    def extract_all(self, html: str, url: str) -> Dict:
        """Extrait tout le contenu d'une page"""
        soup = BeautifulSoup(html, 'html.parser')
        
        result = {
            'url': url,
            'timestamp': time.strftime('%Y-%m-%d %H:%M:%S'),
            'metadata': self.extract_metadata(soup, url),
            'content': self.extract_content(soup),
            'media': self.extract_media(soup),
            'links': self.extract_links(soup, url),
            'region_info': self.extract_region_info(soup),
            'raw_html': html[:10000] + '...' if len(html) > 10000 else html  # Limiter pour le JSON
        }
        
        return result
    
    def scrape_region(self, region_slug: str, region_name: str) -> Dict:
        """Scrape une région et extrait tout son contenu"""
        url = f"{self.BASE_URL}/ou-aller/regions-du-quebec/{region_slug}"
        
        print(f"\n📍 {region_name} ({region_slug})")
        print(f"   URL: {url}")
        
        html = self.fetch_page(url)
        
        if not html:
            print(f"   ❌ Échec du chargement")
            return {'region': region_slug, 'error': 'Page non chargée'}
        
        print(f"   ✅ Page chargée ({len(html)} caractères)")
        
        # Extraire tout le contenu
        content = self.extract_all(html, url)
        content['region_name'] = region_name
        content['region_slug'] = region_slug
        
        print(f"   📊 Contenu extrait:")
        print(f"      - Métadonnées: {len(content['metadata'])} champs")
        print(f"      - Paragraphes: {len(content['content']['paragraphs'])}")
        print(f"      - Images: {len(content['media']['images'])}")
        print(f"      - Liens internes: {len(content['links']['internal'])}")
        print(f"      - Attractions: {len(content['region_info']['attractions'])}")
        
        return content
    
    def scrape_regions(self, regions_to_scrape: List[str]) -> List[Dict]:
        """Scrape plusieurs régions"""
        all_data = []
        total = len(regions_to_scrape)
        
        for idx, slug in enumerate(regions_to_scrape, 1):
            name = self.REGIONS.get(slug, slug)
            print(f"\n{'='*70}")
            print(f"[{idx}/{total}] Traitement de: {name}")
            print(f"{'='*70}")
            
            region_data = self.scrape_region(slug, name)
            all_data.append(region_data)
            
            # Pause entre les requêtes
            time.sleep(1)
        
        return all_data
    
    def export_json(self, data: List[Dict], filename: str):
        """Exporte en JSON"""
        with open(filename, 'w', encoding='utf-8') as f:
            json.dump(data, f, ensure_ascii=False, indent=2)
        print(f"\n✅ Données exportées dans {filename}")
    
    def export_jsonl(self, data: List[Dict], filename: str):
        """Exporte en JSONL (une ligne par région)"""
        with open(filename, 'w', encoding='utf-8') as f:
            for item in data:
                f.write(json.dumps(item, ensure_ascii=False) + '\n')
        print(f"\n✅ Données exportées dans {filename}")
    
    def export_summary_csv(self, data: List[Dict], filename: str):
        """Exporte un résumé en CSV"""
        if not data:
            print("⚠️  Aucune donnée à exporter")
            return
        
        # Préparer les lignes de résumé
        rows = []
        for item in data:
            if 'error' in item:
                continue
            
            row = {
                'region': item.get('region_name', ''),
                'slug': item.get('region_slug', ''),
                'url': item.get('url', ''),
                'title': item.get('metadata', {}).get('title', ''),
                'description': item.get('metadata', {}).get('description', '')[:200],
                'nb_paragraphes': len(item.get('content', {}).get('paragraphs', [])),
                'nb_images': len(item.get('media', {}).get('images', [])),
                'nb_liens_internes': len(item.get('links', {}).get('internal', [])),
                'nb_attractions': len(item.get('region_info', {}).get('attractions', [])),
                'json_ld': len(item.get('metadata', {}).get('json_ld', []))
            }
            rows.append(row)
        
        with open(filename, 'w', newline='', encoding='utf-8') as f:
            if rows:
                writer = csv.DictWriter(f, fieldnames=rows[0].keys())
                writer.writeheader()
                writer.writerows(rows)
        
        print(f"\n✅ Résumé exporté dans {filename}")


def main():
    parser = argparse.ArgumentParser(
        description='Extracteur complet de contenu Bonjour Québec (texte, médias, métadonnées)',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Exemples:
  # Extraire une région complète en JSON
  python bonjourquebec_extract.py --regions cote-nord --output cote-nord.json

  # Extraire toutes les régions
  python bonjourquebec_extract.py --regions all --output tout_quebec.json

  # Extraire plusieurs régions avec résumé CSV
  python bonjourquebec_extract.py --regions montreal quebec --output villes.json --summary

  # Exporter en JSONL (une ligne par région)
  python bonjourquebec_extract.py --regions all --output tout_quebec.jsonl --jsonl
        """
    )
    
    parser.add_argument('--regions', '-r', nargs='+', required=True,
                       help='Slugs des régions ou "all"')
    parser.add_argument('--output', '-o', required=True,
                       help='Fichier de sortie (.json, .jsonl)')
    parser.add_argument('--summary', action='store_true',
                       help='Générer aussi un résumé CSV')
    parser.add_argument('--jsonl', action='store_true',
                       help='Exporter en JSONL (une ligne par région)')
    
    args = parser.parse_args()
    
    scraper = BonjourQuebecContentExtractor()
    
    # Préparer les régions
    if 'all' in args.regions:
        regions = list(scraper.REGIONS.keys())
    else:
        regions = [r for r in args.regions if r in scraper.REGIONS]
        if not regions:
            print("❌ Aucune région valide. Régions disponibles:")
            for slug, name in scraper.REGIONS.items():
                print(f"   {slug}: {name}")
            sys.exit(1)
    
    print("=" * 70)
    print("📚 EXTRACTEUR DE CONTENU BONJOUR QUÉBEC")
    print("=" * 70)
    print(f"📋 {len(regions)} régions à extraire")
    print(f"📋 Format de sortie: {'JSONL' if args.jsonl else 'JSON'}")
    print("=" * 70)
    
    # Extraire les données
    data = scraper.scrape_regions(regions)
    
    if not data:
        print("\n❌ Aucune donnée extraite.")
        sys.exit(1)
    
    # Exporter en JSON ou JSONL
    if args.jsonl:
        scraper.export_jsonl(data, args.output)
    else:
        scraper.export_json(data, args.output)
    
    # Résumé CSV
    if args.summary:
        summary_file = args.output.replace('.json', '_summary.csv').replace('.jsonl', '_summary.csv')
        scraper.export_summary_csv(data, summary_file)
    
    # Statistiques
    success_count = len([d for d in data if 'error' not in d])
    total = len(data)
    
    print(f"\n📊 Résumé:")
    print(f"   - Régions traitées: {total}")
    print(f"   - Réussies: {success_count}")
    print(f"   - Échecs: {total - success_count}")
    
    if success_count > 0:
        # Compter le contenu total
        total_paragraphes = sum(len(d.get('content', {}).get('paragraphs', [])) for d in data if 'error' not in d)
        total_images = sum(len(d.get('media', {}).get('images', [])) for d in data if 'error' not in d)
        total_attractions = sum(len(d.get('region_info', {}).get('attractions', [])) for d in data if 'error' not in d)
        
        print(f"   - Total paragraphes: {total_paragraphes}")
        print(f"   - Total images: {total_images}")
        print(f"   - Total attractions: {total_attractions}")


if __name__ == "__main__":
    main()