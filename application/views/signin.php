    <body>   
        <script>  
            $(document).ready(function(){
                
                $("#form").validate({
 
                    rules: {
                        login: {
                            required: true,
                            minlength: 6,
                            maxlength: 12
                        },
                        pass: {
                            required: true,
                            minlength: 6,
                            maxlength: 12
                        }
                    },
                    messages: {
                        login: {
                            required: "<img src='/image/warning.png'>This field is required",
                            minlength:"<img src='/image/warning.png'>Please enter at least 6 characters.",
                            maxlength:"<img src='/image/warning.png'>Please enter no more than 12 characters."
                        },
                        pass: {
                            required: "<img src='/image/warning.png'>This field is required",
                            minlength:"<img src='/image/warning.png'>Please enter at least 6 characters.",
                            maxlength:"<img src='/image/warning.png'>Please enter no more than 12 characters."
                        }        
                    }
                });
            });
        </script>
        <table id="login" >
            <tr>
                <td>
                    <form id="form" action="" method="post">
                        <table >
                            <tr>
                                <td><span>Username <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="login" class="val" value=""/></td>
                            </tr>
                            <tr>
                                <td><span>Password <b>*</b></span></td>
                            </tr>
                            <tr>
                                <td><input type="password" name="pass" class="val"/></td>
                            </tr>
                            <tr id="right">
                                <td class="little">Forgot your password? <a href="/grid/forgot.php">CLICK HERE</a></td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="signin" value="SIGN IN" class="button"/></td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td>
                    <div id="right">
                        <span>Authorization</span>
                        <br/><br/>                        
                        <p>If you are not an authorized user,</p>
                        <p>please <a href="/grid/register">REGISTER</a></p>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>