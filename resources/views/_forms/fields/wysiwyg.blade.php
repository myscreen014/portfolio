<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    <div <?= $options['wrapperAttrs'] ?> >
    <?php endif; ?>
<?php endif; ?>

<?php if ($showLabel && $options['label'] !== false): ?>
    <?= Form::label($name, $options['label'], $options['label_attr']) ?>
<?php endif; ?>

<?php if ($showField): ?>
    <?= Form::textarea($name, $options['value'], $options['attr']) ?>
    <?php  include base_path('vendor/kris/laravel-form-builder/src/views/help_block.php') ?>
<?php endif; ?>

<?php include base_path('vendor/kris/laravel-form-builder/src/views/errors.php')?>

<?php if ($showLabel && $showField): ?>
    <?php if ($options['wrapper'] !== false): ?>
    </div>
    <?php endif; ?>
<?php endif; ?>


@section('javascript')

	@parent

	<script>
		/* WYSIWYG */	
		tinymce.init({
			language: 'fr_FR',
            selector: "textarea#{{ $name }}",
            plugins: "code, paste, link, file, fullscreen",
            relative_urls: false,
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
            toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link file | code fullscreen",

            setup: function(editor) {
				editor.on('init', function(e) {

					/* Upload files */
					Admin.Upload.init({
						field						: "{{ $name }}",
						fieldType					: "{{ $type }}",
						routeStore					: "{{ route('admin.files.store') }}",
						routeGetitemfilebrowser		: "{{ route('admin.files.getitemfilebrowser') }}",
						modelTable					: "{{ $options['model_table'] }}",
						modelField					: "{{ $options['model_field'] }}",
						modelId						: "{{ $options['model_id'] }}",
						clickable					: "#{{ $name }}-upload-clickable",
						token						: "{{ csrf_token() }}",
						success						: function(file) {
							if (file.type.search(/image/i) == 0) {
								var src = "{{ route('picture', ['wysiwyg', ':fileName']) }}";
								src = src.replace(':fileName', file['path']);
						  		editor.insertContent('<img src="'+src+'"/>');
							} else {
								var href = "{{ route('file', ':fileName') }}";
								href = href.replace(':fileName', file['path']);
								editor.insertContent('<a href="'+href+'" target="_blank">'+href+'</a>');
							}
						},
					});
				});
            }
        });
	</script>

@stop
