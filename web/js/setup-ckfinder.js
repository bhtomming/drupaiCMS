CKFinder.setupCKEditor( null, {basePath: '/ckfinder/',authentication : true} );
var editor = CKEDITOR.replace( 'editor1' );
function CheckAuthentication()
{
    return true;
}