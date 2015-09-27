<?php
    include_once "../../include/koneksi.php";
    session_start();
?>

<nav class="navbar navbar-custom" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
				<li><a href="#" id="beranda" class="beranda"><span class="glyphicon glyphicon-home"> Beranda</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span> Data Master<span class="caret"></span></a>
					<ul class="dropdown-menu " role="menu">
					<?php
						$rights_group=mysql_query("select * from rights_group where ID='$_SESSION[AKSES]'");
						$rights_groupdata=mysql_fetch_array($rights_group);
						$data=$rights_groupdata["AKSES"];
						$tmptrights_group=array();
						$tmptrights_group=explode(",",$data);
						$mastermenu=mysql_query("select * from rights_menu where ID < '11' or ID='28' or ID='34' or ID='35' or ID='36' or ID='37' or ID='42' or ID='49'");
						
						while($datamastermenu=mysql_fetch_object($mastermenu)){
							foreach($tmptrights_group as $datarights){	
						
					?>
						<li style="letter-spacing:2px;word-spacing:-0.8em;"><a href="#" <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?>  id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-align-right"><?php echo $datamastermenu->MENU_NAME;?></a></li>
					<?php  } ?>
					<?php  } ?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span>Proses Penggajian<span class="caret"></span></a>
					<ul class="dropdown-menu " role="menu">
					<?php
						$mastermenu=mysql_query("select * from rights_menu where ID='12' or ID='38' or ID='27' or ID='45'  ");
					
						while($datamastermenu=mysql_fetch_object($mastermenu)){
							foreach($tmptrights_group as $datarights){
					?>
						<li style="letter-spacing:2px;word-spacing:-0.8em;"><a href="#" <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?>  id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-save-file"><?php echo $datamastermenu->MENU_NAME;?></a></li>
					<?php } ?>
					<?php } ?>
					</ul>
				</li>
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span>Data Laporan<span class="caret"></span></a>
					<ul class="dropdown-menu " role="menu">
					<?php
						$mastermenu=mysql_query("select * from rights_menu where ID = '13' or ID='26' or ID='29' or ID='39' or ID='44'");
						
						while($datamastermenu=mysql_fetch_object($mastermenu)){
							foreach($tmptrights_group as $datarights){
					?>
						<li style="letter-spacing:2px;word-spacing:-0.8em;"><a href="#" <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?> id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-book"><?php echo $datamastermenu->MENU_NAME;?></a></li>
					<?php } ?>
					<?php } ?>
					</ul>
				</li>
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span>Rekapitulasi<span class="caret"></span></a>
					<ul class="dropdown-menu " role="menu">
					<?php
						$mastermenu=mysql_query("select * from rights_menu where ID = '31' OR ID='32' OR ID='40' OR ID='43' OR ID='48' ");
						
						while($datamastermenu=mysql_fetch_object($mastermenu)){
							foreach($tmptrights_group as $datarights){
					?>
						<li style="letter-spacing:2px;word-spacing:-0.8em;"><a href="#" <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?> id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-book"><?php echo $datamastermenu->MENU_NAME;?></a></li>
					<?php } ?>
					<?php } ?>
					</ul>
				</li>
				<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-tasks"></span>Penyesuaian<span class="caret"></span></a>
					<ul class="dropdown-menu " role="menu">
					<?php
						$mastermenu=mysql_query("select * from rights_menu where ID = '25' OR ID='41' ");
						
						while($datamastermenu=mysql_fetch_object($mastermenu)){
							foreach($tmptrights_group as $datarights){
					?>
						<li style="letter-spacing:2px;word-spacing:-0.8em;"><a href="#" <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?> id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-export"><?php echo $datamastermenu->MENU_NAME;?></a></li>
					<?php } ?>
					<?php } ?>
					</ul>
				</li>
				<?php
					$mastermenu=mysql_query("select * from rights_menu where ID = '15'");
					
					while($datamastermenu=mysql_fetch_object($mastermenu)){
						foreach($tmptrights_group as $datarights){
				?>
					<li ><a href="#" <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?> id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-user"><?php echo $datamastermenu->MENU_NAME;?></a></li>
				<?php } ?>
				<?php } ?>
		    </ul>
            <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
                    <a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> Pengaturan<span class="caret"></span></a>
					<ul class="dropdown-menu " role="menu">
					<?php
						$mastermenu=mysql_query("select * from rights_menu where ID >'15' and ID < 25 or ID='30' or ID='33' or ID='46' or ID='47' or ID='50'");
						
						while($datamastermenu=mysql_fetch_object($mastermenu)){
							foreach($tmptrights_group as $datarights){
					?>
						<li style="letter-spacing:2px;word-spacing:-0.8em;"><a  href="#"  <?php  if($datarights!=$datamastermenu->ID){echo 'style="display:none"'; }?> id="<?php echo $datamastermenu->MENU_LINK;?>" class="<?php echo $datamastermenu->MENU_LINK;?>"><span class="glyphicon glyphicon-cog"><?php echo $datamastermenu->MENU_NAME;?></a></li>
					<?php } ?>
					<?php } ?>

					</ul>
                </li>
				<li><a href="#" id="logout" class="logout"><span class="glyphicon glyphicon-log-out"></span> Keluar sistem [<?php echo $_SESSION['NAMA_PETUGAS']; ?>]</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
