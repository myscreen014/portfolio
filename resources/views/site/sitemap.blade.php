<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@foreach($pages as $page)
		<loc>{{ route('page', $page->slug) }}</loc>
		<priority>0.4</priority>
	@endforeach
</urlset>
