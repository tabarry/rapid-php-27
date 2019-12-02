<?php include('includes/include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include('inc-head.php'); ?>
    </head>
    <body>
        <div id="wrapper">
            <!--HEADER-->
            <?php include('inc-header.php'); ?>
            <!--CONTENT-->
            <div id="content">
                <h2>Step 1/3: Select Database</h2>
                <form id="form1" name="form1" method="post" action="step2.php" onsubmit="return validate1();">
                    <select name="db" id="db">
                        <option>Select...</option>
                        <?PHP
                        //Select database
                        $sql = "SHOW DATABASES";
                        $rs = mysqli_query($cn,$sql) or die(mysqli_error($cn));
                        while ($row = mysqli_fetch_array($rs)) {
                            ?>
                            <option>
                                <?= $row[0]; ?>
                            </option>
                            <?PHP
                        }
                        mysqli_free_result($rs);
                        mysqli_close($cn);
                        ?>
                    </select>
                    <p>
                        <input type="submit" name="Submit" value="Next &raquo;&raquo;" />
                    </p>
                    <p>*Table designing tips:</p>
                    <ol>
                        <li>__ will make field label</li>
                        <li>|s in comments field will show field on manage page</li>
                        <li>|fieldId,fieldText will make it a dropdown from database </li>
                        <li>__File will make file field, __Picture will make picture field, __Attachment will make attachment field, __Date for date field</li>

                    </ol>
                </form>
            </div>
            <!--FOOTER-->
            <?php include('inc-footer.php'); ?>
        </div>
    </body>
</html>
