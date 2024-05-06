<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKEditor 5 – Classic editor</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <style>
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            text-align: right !important;

        }
    </style>
</head>
<body>
    <form action="{{url('editor-post')}}" method="post">
        @csrf
        <h1>Classic editor</h1>
        <div >
            <textarea name="textArea" id="editor"cols="30" rows="10"></textarea>
        </div>
        <input type="submit" value="Send">
    </form>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>