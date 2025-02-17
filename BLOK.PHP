<html>
<head>
    <title>Download Script Form Input Data | PHP MySQL Tutorial</title>
    <style type="text/css" media="screen">
        table {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;}
        input {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;height: 20px;}
    </style>
</head>
<body>
<div style="border:1; padding:10px; width:760px; height:auto;">
<form action="koneksiblok.php" method="post" name="koneksiblok">
    <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr height="50">
                <td width="20%"> </td>
                <td width="35%"> </td>
                <td width="75%"><font color="GREEN" size="4">Form Input Data Blok</font></td>
        </tr>
        <tr height="50">
            <td> </td>
            <td>Id Blok</td>
            <td><input type="text" name="Id_Blok" size="10" maxlength="6" /></td>
        </tr>
        <tr height="50">
            <td> </td>
            <td>Blok</td>
            <td><input type="text" name="Blok" size="10" maxlength="6" /></td>
        </tr>
        <tr height="50">
            <td> </td>
            <td> </td>
            <td><input type="submit" name="Submit" value="Simpan">   
                <input type="reset" name="reset" value="Cancel">
				<input type="button" name="button" value="Kembali">
				</td>
        </tr>
		</tr>
    </table>
</form>
</div>
</body>
</html>

