<style>
.file_upload{
    position: relative;
    overflow: hidden;
    font-size: 1em;        /* example */
    height: 2em;           /* example */
    line-height: 2em       /* the same as height */
}
.file_upload > button, .file_upload > div{
    cursor: pointer
}
.file_upload > button{
    float: right;
    width: 8em;            /* example */
    height: 100%
}
.file_upload > div{
    padding-left: 1em      /* example */
}
@media only screen and ( max-width: 500px ){  /* example */
    .file_upload > div{
        display: none
    }
    .file_upload > button{
        width: 100%
    }
}
.file_upload input[type=file]{
    position: absolute;
    top: 0;
    visibility: hidden
}

/* Making it beautiful */

.file_upload{
    border: 1px solid #ccc;
    border-radius: 3px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    transition: box-shadow 0.1s linear
}
.file_upload.focus{
    box-shadow: 0 0 5px rgba(0,30,255,0.4)
}
.file_upload > button{
    background: #7300df;
    transition: background 0.2s;
    border: 1px solid rgba(0,0,0,0.1);
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    border-radius: 2px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #fff;
    text-shadow: #6200bd 0 -1px 0;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis
}
.file_upload:hover > button{
    background: #6200bd;
    text-shadow: #5d00b3 0 -1px 0
}
.file_upload:active > button{
    background: #5d00b3;
    box-shadow: 0 0 3px rgba(0,0,0,0.3) inset
}


</style>

<script>

$(function(){
    var wrapper = $( ".file_upload" ),
        inp = wrapper.find( "input" ),
        btn = wrapper.find( "button" ),
        lbl = wrapper.find( "div" );

    // Crutches for the :focus style:
    btn.focus(function(){
        wrapper.addClass( "focus" );
    }).blur(function(){
        wrapper.removeClass( "focus" );
    });

    // Yep, it works!
    btn.add( lbl ).click(function(){
        inp.click();
    });

    var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

    inp.change(function(){

        var file_name;
        if( file_api && inp[ 0 ].files[ 0 ] )
            file_name = inp[ 0 ].files[ 0 ].name;
        else
            file_name = inp.val().replace( "C:\\fakepath\\", '' );
        if( ! file_name.length )
            return;

        if( lbl.is( ":visible" ) ){
            lbl.text( file_name );
            btn.text( "Выбрать" );
        }else
            btn.text( file_name );
    }).change();

});
$( window ).resize(function(){
    $( ".file_upload input" ).triggerHandler( "change" );
});

</script>




  <div class="file_upload">
        <button type="button">Выбрать</button>
        <div>Файл не выбран</div>
        <input type="file">
    </div>
    
    
    
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    
    
    
    
    