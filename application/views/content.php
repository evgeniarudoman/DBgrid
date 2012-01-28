
                                    <table class='tables fff'>
                                        <tr>
                                            <td class ='disp'></td><td bgcolor='#002F32'>#</td>
                                                <?php for ($i = 0; $i < mysql_num_fields($result); $i++):?>
                                            <td bgcolor='#002F32' name='<?php echo $i ?>'><div class='resDiv'><?php echo mysql_field_name($result, $i); ?></div></td>
                                                <?php endfor;?>
                                        </tr>
                                        <?php  $j = 1;
                                        while ($row = mysql_fetch_array($result)):?>
                                        <tr>
                                            <td><div class="icon checkbox"><input type='checkbox'></div></td>
                                            <td class='id'><?php echo $j ?></td>
                                        <?php for ($i = 0; $i < mysql_num_fields($result); $i++):?>
                                            <td><div class ='href inp'><?php echo $row[mysql_field_name($result, $i)] ?></div></td>
                                        <?php endfor;?>
                                        </tr>
                                        <?php $j++;?>
                                        <?php endwhile;?>
                                    </table>
                            