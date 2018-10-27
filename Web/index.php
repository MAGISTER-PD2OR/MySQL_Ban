<?php
    
    $config    =    array(
        'host'        =>    'localhost',        //Database host
        'username'    =>    'root',        //Database username
        'password'    =>    'your-pw',        //Database password
        'dbname'    =>    'there-db',        //Database name
        
        'perpage'    =>    20,                    //Amount of bans to show per page
    );
    
    $link = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname']);
	mysqli_query($link, 'set player_name UTF-8');
	
    $currentPage = empty($_GET['page'])||!is_numeric($_GET['page'])||$_GET['page']<1?1:(int)$_GET['page'];
    $query = mysqli_query($link, 'SELECT * FROM `my_bans` ORDER BY `id` DESC LIMIT '.(($currentPage-1)*$config['perpage']).','.$config['perpage']);
    $pageResults = mysqli_num_rows(mysqli_query($link, 'SELECT * FROM `my_bans`'));
	include_once 'common.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $lang['PAGE_TITLE']; ?></title>
		<link href="css/style.css" rel="stylesheet" type="text/css" media="all">

    </head>
    <body>
	<div align="center">
	<div id="languages" style="text-align: center;">
	<a href="index.php?lang=en"><img src="images/en.png" /></a>
	<a href="index.php?lang=fr"><img src="images/fr.png" /></a>
	<a href="index.php?lang=de"><img src="images/de.png" /></a>
	<a href="index.php?lang=es"><img src="images/es.png" /></a>
	<a href="index.php?lang=ru"><img src="images/ru.png" /></a>
</div>
        <?php
            if(mysqli_num_rows($query) == 0){
                //echo 'No players currently on the banlist...';
				echo $lang['NO_PLAYERS'];
            }else{
        ?>
        <table id="table-b" style="text-align: center;">
            <thead>
                <tr>
                    <th scope="col"><?php echo $lang['STEAMID_PLAYERS']; ?></th>
                    <th scope="col"><?php echo $lang['NAME_PLAYERS']; ?></th>
                    <th scope="col"><?php echo $lang['BAN_REASON']; ?></th>
                    <th scope="col"><?php echo $lang['BANNED_BY']; ?></th>
                    <th scope="col"><?php echo $lang['LENGTH_BAN']; ?></th>
                    <th scope="col"><?php echo $lang['TIME_PLAYER']; ?></th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <td colspan="5">
                    <?php
					  if($pageResults>$config['perpage']){
						$pageUrl = '?page=';
						if($currentPage>1){
							  echo "<a href=\"".$pageUrl.($currentPage-1)."\">{$lang['PAGE_PREVIOUS']}</a>&nbsp;";
						}
						$totalPages = ceil($pageResults/$config['perpage']);
						for($i=1;$i<=$totalPages;++$i){
							  echo '<a href="',$pageUrl,$i,'">',$i,'</a>&nbsp;';
						}
						if($currentPage<$totalPages){
							  echo "<a href=\"".$pageUrl.($currentPage+1)."\">{$lang['PAGE_NEXT']}</a>&nbsp;";
						}
					  }
					?>
                    </td>
                    <td class="tfoot">&nbsp;</td>
                </tr>
            </tfoot>
        <?php
                while($row = mysqli_fetch_assoc($query)){
                    echo '<tr><td>',$row['steam_id'],'</td><td>',htmlentities($row['player_name'], ENT_QUOTES, "UTF-8"),'</td><td>',htmlentities($row['ban_reason']),'</td><td>',htmlentities($row['banned_by'], ENT_QUOTES, "UTF-8"),'</td><td>',$row['ban_length'],'</td><td>',$row['timestamp'],'</td></tr>';
                }
                echo '</table>';
            }
        ?>
    </div>
	</body>
</html>