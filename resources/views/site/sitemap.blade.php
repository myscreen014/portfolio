<?xml version="1.0" encoding="UTF-8"?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@foreach($urls as $url)
		<loc>{{ $url['loc'] }}</loc>
		<priority>{{ $url['priority'] }}</priority>
	@endforeach
</urlset>
