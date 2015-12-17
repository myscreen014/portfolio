
<div class="form-wrapper" >

	@if (count($errors) > 0)
        <ul class="errors alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
	@endif

	{!! form($form) !!}

</div>

@section('javascript')
	
	@parent

	<script type="text/javascript">
	
		/* FORM */
		$(document).ready(function() {
			$('.form-wrapper').fadeIn('fast');
		});

		/* WYSIWYG */	
		tinymce.init({
			language: 'fr_FR',
            selector: "textarea.wysiwyg",
            plugins: "code, paste, link",
            menubar: false,
            height : 200,
            content_css : "{{ asset('css/wysiwyg.css') }}",
            paste_as_text: true,
           	style_formats : [
           		{title : "Headings", items: [
	           		{ title: "Heading 1", block : 'h1'},
	           		{ title: "Heading 2", block : 'h2'},
	           		{ title: "Heading 2", block : 'h3'},
	           	]},
	           	{title : "Blocks", items: [
	           		{ title: "Paragraph", block : 'p'},
	           		{ title: "Blockquote", block : 'blockquote'},
	           	]}
            ],
            formats: {
				alignleft: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_left', styles: {textAlign: 'left'}, defaultBlock: 'div'},
					{selector: 'img,table', collapsed: false, classes: 'align_left', styles: {'float': 'left'}}
				],
				aligncenter: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_center', styles: {textAlign: 'center'}, defaultBlock: 'div'},
					{selector: 'img', collapsed: false, classes: 'align_center', styles: {display: 'block', marginLeft: 'auto', marginRight: 'auto'}},
					{selector: 'table', collapsed: false, classes: 'align_center', styles: {marginLeft: 'auto', marginRight: 'auto'}}
				],
				alignright: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_right', styles: {textAlign: 'right'}, defaultBlock: 'div'},
					{selector: 'img,table', collapsed: false, classes: 'align_right', styles: {'float': 'right'}}
				],
				alignjustify: [
					{selector: 'figure,p,h1,h2,h3,h4,h5,h6,td,th,tr,div,ul,ol,li', classes: 'align_justify', styles: {textAlign: 'justify'}, defaultBlock: 'div'},
					{selector: 'img', collapsed: false, classes: 'align_justify', styles: {display: 'block'}}
				]
			},
            toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | code"
        });
	</script>

@endsection