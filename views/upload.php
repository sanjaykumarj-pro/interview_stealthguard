<header>
    <h1>Upload</h1>
</header>

<div class="container">
    <div class="content">
        <a href="http://localhost/interviews/stealthguard/auth/logout" style="float: right;">Logout</a>
        <form method="post" enctype="multipart/form-data" action="http://localhost/interviews/stealthguard/upload/submit">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            Select file <input type="file" name="upload_file"/><br/><br/>
            <input type="submit" value="Go" name="submit"/>

            <?php if(isset($_SESSION['message'])) echo "<br/><br/>".$_SESSION['message'];?>

        </form>

        <?php if(!empty($uploaded_files)) {?>
        <br/><br/>
        <table>
            <tr>
                <th style="text-align: left;padding-bottom: 20px;">Uploaded Files</th>
            </tr>
            <?php foreach($uploaded_files as $uploaded_file) {?>
                <tr>
                    <td><a href="http://localhost/interviews/stealthguard/download/image?id=<?php echo $uploaded_file['id'];?>" target="_blank"><?php echo $uploaded_file['filename'];?></a></td>
                </tr>
            <?php }?>
        </table>
        <?php }?>
    </div>
</div>