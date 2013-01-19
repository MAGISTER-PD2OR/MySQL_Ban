<?php
    
    $config    =    array(
        'host'        =>    'localhost',        //Database host
        'username'    =>    'username',        //Database username
        'password'    =>    'password',        //Database password
        'dbname'    =>    'database',        //Database name
        
        'perpage'    =>    20,                    //Amount of bans to show per page
    );
    
    //---------
    
    mysql_connect($config['host'], $config['username'], $config['password']) or die('Couldn\'t connect to the database.');
    mysql_select_db($config['dbname']) or die('Couldn\'t select the database.');
    
    $currentPage = empty($_GET['page'])||!is_numeric($_GET['page'])||$_GET['page']<1?1:(int)$_GET['page'];
    $query = mysql_query('SELECT * FROM `my_bans` ORDER BY `id` DESC LIMIT '.(($currentPage-1)*$config['perpage']).','.$config['perpage']);
    $pageResults = mysql_num_rows(mysql_query('SELECT * FROM `my_bans`'));
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
	<div id="languages" style="text-align: center;">
	<a href="bans.php?lang=en"><img src="images/en.png" /></a>
	<a href="bans.php?lang=fr"><img src="images/fr.png" /></a>
	<a href="bans.php?lang=de"><img src="images/de.png" /></a>
	<a href="bans.php?lang=es"><img src="images/es.png" /></a>
	<a href="bans.php?lang=ru"><img src="images/ru.png" /></a>
</div>
        <?php
            if(mysql_num_rows($query) == 0){
                //echo 'No players currently on the banlist...';
				echo $lang['NO_PLAYERS'];
            }else{
        ?>
        <table id="table-b">
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
                                echo '<a href="',$pageUrl,($currentPage-1),'">Previous</a>&nbsp;';
                            }
                            $totalPages = ceil($pageResults/$config['perpage']);
                            for($i=1;$i<=$totalPages;++$i){
                                echo '<a href="',$pageUrl,$i,'">',$i,'</a>&nbsp;';
                            }
                            if($currentPage<$totalPages){
                                echo '<a href="',$pageUrl,($currentPage+1),'">Next</a>&nbsp;';
                            }
                        }
                    ?>
                    </td>
                    <td class="tfoot">&nbsp;</td>
                </tr>
            </tfoot>
        <?php
                while($row = mysql_fetch_assoc($query)){
                    echo '<tr><td>',$row['steam_id'],'</td><td>',htmlentities($row['player_name'], ENT_QUOTES, "UTF-8"),'</td><td>',htmlentities($row['ban_reason']),'</td><td>',htmlentities($row['banned_by'], ENT_QUOTES, "UTF-8"),'</td><td>',$row['ban_length'],'</td><td>',$row['timestamp'],'</td></tr>';
                }
                echo '</table>';
            }
        ?>
    </body>
</html>