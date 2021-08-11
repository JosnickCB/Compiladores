<!DOCTYPE html>
<html lang="es">
<head>
    <title>Compilador</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="utf-8" />
    <style>
        body {
            background-color:   black;
        }
        form {
            width:              100%;
        }
        textarea {
            background-color:   black;
            color:              white;
            resize:             none;
            width:              100%;
            height:             40vh;
            margin:             -3px;
        }
        .my_text {
            font-family:        'Lucida Console';
            font-size:          15px;
            font-weight:        lighter;
            color:              #FFFFFF
        }
    </style>
</head>
<body>
    <h1 style ='color:#FFFFFF'>LOW COMPILER</h1>
    <form>
        <textarea name ="code_text" id="code_text"></textarea>
        <input type='button' value ="Compilar" style="width:100vh;" onclick="compile();">
        <input type='button' value ="Debugear" style="width:100vh" onclick="debug_compile();">
        <!--input type='button' value ="" style="width:auto"-->
    </form>
    <div style="background-color: #0342ff; color:#6c03ff; display: block; height: 40vh;" >
        <div style="background-color: #ffec19"> CONSOLA</div>
        <div class ="my_text" id="console_div"></div>
    </div>
    <script>
        $("textarea").keydown(function(e) {
            if(e.keyCode === 9) { // tab was pressed
                // get caret position/selection
                var start = this.selectionStart;
                var end = this.selectionEnd;

                var $this = $(this);
                var value = $this.val();

                // set textarea value to: text before caret + tab + text after caret
                $this.val(value.substring(0, start)
                            + "\t"
                            + value.substring(end));

                // put caret at right position again (add one for the tab)
                this.selectionStart = this.selectionEnd = start + 1;

                // prevent the focus lose
                e.preventDefault();
            }
        });
    </script>
    <script>
        function compile(){
            var code_text = $('#code_text').val();
            console.log(code_text);
            var lines = code_text.split('\n');
            console.log(lines);

            var content = {};

            for(let i=0;i<lines.length;i++){
                content[i] = lines[i];
            }

            $.ajax({
                data : content,
                url : 'compiler.php',
                type : 'POST',
                beforeSend : function(){
                    $('#console_div').html();
                },
                success : function(msg){
                    $('#console_div').html(msg);
                }
            });
        }
    </script>
    <script>
        function debug_compile(){
            var code_text = $('#code_text').val();
            console.log(code_text);
            var lines = code_text.split('\n');
            console.log(lines);

            var content = {};

            for(let i=0;i<lines.length;i++){
                content[i] = lines[i];
            }

            $.ajax({
                data : content,
                url : 'full_compile.php',
                type : 'POST',
                beforeSend : function(){
                    $('#console_div').html();
                },
                success : function(msg){
                    $('#console_div').html(msg);
                }
            });
        }
    </script>
</body>
</html>