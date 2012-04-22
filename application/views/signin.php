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
        <table id="login">
            <tr>
                <td>
                    <form id="form" action="" method="post">
                        <table >
                            <tr>
                                <td>
                                    <span>
                                        <b>
                                        <?php
                                            $error = $this->session->userdata('error');
                                            if (isset($error) && !empty($error))
                                            {
                                                echo $error;
                                            }
                                        ?>
                                        </b>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Username <span class="star">*</span></span></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="username" class="val" value=""/></td>
                            </tr>
                            <tr>
                                <td><span>Password <span class="star">*</span></span></td>
                            </tr>
                            <tr>
                                <td><input type="password" name="password" class="val"/></td>
                            </tr>
                            <tr id="right">
                                <td class="little">If you are not an authorized user, please <a href="/grid/register">REGISTER</a></td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="signin" value="SIGN IN" class="btn btn-primary"/></td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>