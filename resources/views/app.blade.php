<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}?t={{ time() }}">
</head>
<body>
<div id="app"></div>

<script>
    var allData = '{{ route('all_data') }}';
    var ruleAll = '{{ route('rule.all') }}';
    var ruleStore = '{{ route('rule.store') }}';
    var ruleUpdate = '{{ route('rule.update', ['rule' => 123456789]) }}';
    var ruleDelete = '{{ route('rule.delete', ['rule' => 123456789]) }}';

    var countryAll = '{{ route('country.all') }}';
    var countryStore = '{{ route('country.store') }}';
    var countryUpdate = '{{ route('country.update', ['country' => 123456789]) }}';
    var countryDelete = '{{ route('country.delete', ['country' => 123456789]) }}';

    var typeAll = '{{ route('types.all') }}';
    var typeStore = '{{ route('types.store') }}';
    var typeUpdate = '{{ route('types.update', ['type' => 123456789]) }}';
    var typeDelete = '{{ route('types.delete', ['type' => 123456789]) }}';

    var categoryAll = '{{ route('category.all') }}';
    var categoryStore = '{{ route('category.store') }}';
    var categoryUpdate = '{{ route('category.update', ['category' => 123456789]) }}';
    var categoryDelete = '{{ route('category.delete', ['category' => 123456789]) }}';

    var storeRule = '{{ route('category.storeRule') }}';
    var deleteRule = '{{ route('category.deleteRule', ['category' => 123456789]) }}';
</script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="{{mix('js/app.js')}}?t={{ time() }}"></script>
</html>