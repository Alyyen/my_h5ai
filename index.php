<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/W-PHP-501-LIL-1-1-myh5ai-alyssia.colomar/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H5AI</title>
    <link href="./style.css" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <div class="row" id="header">
        <h1 class="header-element">H5AI</h1>
        <h2 class="header-element">
			<?php $my_arr = explode("/", $_GET['path']);
				foreach ($my_arr as $key => $value) {
					if ($key != 0) {
						$url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
						?><span class="color-gray"> > </span><a
                        href="<?php print $url . "/" . $_GET['path'] ?>"><?php print $value ?></a><?php
					} else {
						$url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
						?><a href="<?php print $url . "/" . $value ?>"><?php print $value ?></a><?php
					}
				} ?></h2>
        <div class="input-group rounded">
            <input type="search" id="searchbar" class="form-control rounded" placeholder="Search" aria-label="Search"
                   aria-describedby="search-addon"/>
        </div>
    </div>
    <div class="row">
        <div id="answer-searchbar"></div>
    </div>
    <div class="row">

        <section id="menu" class="col-md-4 col-xs-6">
            <ul>
				<?php
					include('database.php');
					// /usr/local/var/www/W-PHP-501-LIL-1-1-myh5ai-alyssia.colomar/folder
					// /Users/alyssiacolomar/folder
					$path = $_GET['path'];
					if (isset($path)) {
						$object = new H5AI($path);
						?>
                        <li><i class="fa-solid fa-box-archive"></i>&nbsp;<?php print $_GET['path'] ?></li>
						<?php
						$tab_val = "&nbsp;";
						$tab_number = 5;
						$object->printTree($object->getFiles($path, []), $tab_number, $tab_val);
					}
				?>
            </ul>
        </section>
        <section id="array" class="col-md-8 col-xs-6">
            <div id="array-header">
                <span>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span>Last change&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span>Size</span>
            </div>
            <hr>
			<?php
				$object = new H5AI($path);
				$object->arrayTree($path);
			?>
        </section>
    </div>

    <!-- MODAL TO OPEN FILE -->
    <div id="modal-file-open" class="modal" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body" id="modal-file-content">
                </div>
                <div class="modal-footer">
                    <h5 id="modal-title"></h5>
                    <a class="btn modal-btn" id="dl-content-btn"><i class="fa-solid fa-download"></i></a>
                    <button type="button" class="close btn modal-btn" id="close-modal" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
<script src="./script.js" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/4fabc986ab.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>