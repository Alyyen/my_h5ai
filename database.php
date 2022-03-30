<?php

	class H5AI {
		// Properties
		private $_tree;
		private $_path;

		// Construct
		public function __construct($_path) {
			$this->_path = $_path;
			// Initialize the path name as array
			$pathname = $_path;

			// Get content of the path
			//$this->_tree = $this->getFiles($_path, []);

			// Increment tab for tree
			$tab_val = "&nbsp;";
			$tab_number = 5;

			// Print path name and its tree
			/*print "<ul>";
			print "<li>" . "<i class=\"fa-solid fa-box-archive\"></i>" . $tab_val . $pathname . "</li>";
			$this->printTree($this->_tree, $tab_number, $tab_val);
			print "</ul>";*/

			//$this->arrayTree($this->_tree);
		}

		// Methods
		function getPath() {
			return $this->_path;
		}

		function getTree() {
			return $this->_tree;
		}

		// Scandir
		private function new_scandir($dir) {
			$dir_arr = scandir($dir);
			return $dir_arr;
		}

		// Get files from the given path
		function getFiles($fileList, array $parent) {
			$path = $fileList;
			$fileList = $this->new_scandir($fileList);

			foreach ($fileList as $fileElement) {
				$realpath = realpath($path . DIRECTORY_SEPARATOR . $fileElement);

				if($fileElement != '.' && $fileElement != '..' && $fileElement != '.DS_Store'){
					if (is_dir($realpath)) {
						$newrealpath = realpath($path . DIRECTORY_SEPARATOR . $fileElement);

						$parent[$fileElement] = $this->getFiles($newrealpath, []);
					} else if (is_file($realpath)) {
						$parent[] = $fileElement;
					}
				}
			}
			return $parent;
		}

		// Print the tree as list
		function printTree($_tree, $tab_number, $tab_val){
			$tab = str_repeat($tab_val, $tab_number);
			$li_start = "<li>";
			$li_end = "</li>";
			// Echo each key of the tree
			foreach ($_tree as $key => $value){
				if(is_array($value)){
					print $li_start . $tab . "<i class=\"fa-solid fa-folder\"></i>" . $tab_val . $key . $li_end;
					$this->printTree($value, $tab_number += 5, $tab_val);
					$tab_number -= 5;
				}elseif (is_string($value)){
					$path_arr = pathinfo($value);
					$path_extension = $path_arr['extension'];

					// Switch type of file
					switch ($path_extension){
						case "zip":
						case "tar":
							print $li_start . $tab .  "<i class=\"fa-solid fa-file-zipper\"></i>" . $tab_val . $value . $li_end;
							break;
						// TEXT FILES
						case "pdf":
							print $li_start . $tab .  "<i class=\"fa-solid fa-file-pdf\"></i>" . $tab_val . $value . $li_end;
							break;
						case "txt":
							print $li_start . $tab .  "<i class=\"fa-solid fa-file-lines\"></i>" . $tab_val . $value . $li_end;
							break;
						// IMAGES FILES
						case "png":
						case "svg":
						case "jpg":
						case "jpeg":
						case "bmp":
						case "ico":
						case "gif":
							print $li_start . $tab .  "<i class=\"fa-solid fa-image\"></i>" . $tab_val . $value . $li_end;
							break;
						// MUSIC FILES
						case "mp3":
							print $li_start . $tab .  "<i class=\"fa-solid fa-music\"></i>" . $tab_val . $value . $li_end;
							break;
						case "mp4":
							print $li_start . $tab .  "<i class=\"fa-solid fa-play\"></i>" . $tab_val . $value . $li_end;
							break;
						// WEB LANGUAGES
						case "html":
							print $li_start . $tab . "<i class=\"fa-brands fa-html5\"></i>" . $tab_val . $value . $li_end;
							break;
						case "js":
							print $li_start . $tab . "<i class=\"fa-brands fa-js\"></i>" . $tab_val . $value . $li_end;
							break;
						case "css":
							print $li_start . $tab . "<i class=\"fa-brands fa-css3\"></i>" . $tab_val . $value . $li_end;
							break;
						case "php":
							print $li_start . $tab . "<i class=\"fa-brands fa-php\"></i>" . $tab_val . $value . $li_end;
							break;
						case "java":
							print $li_start . $tab . "<i class=\"fa-brands fa-java\"></i>" . $tab_val . $value . $li_end;
							break;
						case "py":
							print $li_start . $tab . "<i class=\"fa-brands fa-python\"></i>" . $tab_val . $value . $li_end;
							break;
						case "apk":
							print $li_start . $tab . "<i class=\"fa-brands fa-android\"></i>" . $tab_val . $value . $li_end;
							break;
						// SETTINGS FILES
						case "exe":
							print $li_start . $tab . "<i class=\"fa-solid fa-gear\"></i>" . $tab_val . $value . $li_end;
							break;
						default:
							print $li_start . $tab . "<i class=\"fa-solid fa-file\"></i>" . $tab_val . $value . $li_end;
							break;
					}
				}
			}
		}

		// Print the tree as array
		function arrayTree($_path){
			$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			// Content of the link for each file
			$link = "<a data-dismiss=\"modal\" data-toggle=\"modal\" data-target=\"#modal-file-open\" href=\"#modal-file-open\" class=\"btn file-to-open\">";
			// Url to redirection
			$url = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
			// Stock path string to search inside
			$path = $_path;
			// Name of current element opened
			$actual = substr(strrchr($path, "/"), 1);
			// Change path for going back
			$path = str_replace("/" . $actual, "", $path);
			if ($path != $_path){
				print "<a href=\"" . $url . DIRECTORY_SEPARATOR. $path . "\">" . "<i class=\"fa-solid fa-arrow-left\"></i> " . $path . "</a>" . "<br>" . "<hr>";
			}
			$_tree = $this->getFiles($_path, []);
			foreach ($_tree as $key => $value){
				if(is_array($value)){
					// Change the directory name as link to its subfolder
					print "<a class=\"array-folder btn\" href=\"" . $url . DIRECTORY_SEPARATOR. $_path . DIRECTORY_SEPARATOR. $key . "\"><i class=\"fa-solid fa-folder\"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $key . "</a>" . "<br>" . "<hr>";
				}elseif (is_string($value)) {
					$dateformat = $tab . date ("F d, Y (H:i)", filemtime($_path . DIRECTORY_SEPARATOR . $value)) . $tab;
					$filesize = $tab . filesize($_path . DIRECTORY_SEPARATOR . $value);

					$path_arr = pathinfo($value);
					$path_extension = $path_arr['extension'];

					// print $link . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
					// Switch type of file
					switch ($path_extension){
						case "zip":
						case "tar":
							print $link . "<i class=\"fa-solid fa-file-zipper\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						// TEXT FILES
						case "pdf":
							print $link . "<i class=\"fa-solid fa-file-pdf\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "txt":
							print $link . "<i class=\"fa-solid fa-file-lines\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						// IMAGES FILES
						case "png":
						case "svg":
						case "jpg":
						case "bmp":
						case "ico":
						case "gif":
							print $link . "<i class=\"fa-solid fa-image\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						// MUSIC FILES
						case "mp3":
							print $link . "<i class=\"fa-solid fa-music\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "mp4":
							print $link . "<i class=\"fa-solid fa-play\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						// WEB LANGUAGES
						case "html":
							print $link . "<i class=\"fa-brands fa-html5\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "js":
							print $link . "<i class=\"fa-brands fa-js\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "css":
							print $link . "<i class=\"fa-brands fa-css3\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "php":
							print $link . "<i class=\"fa-brands fa-php\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "java":
							print $link . "<i class=\"fa-brands fa-java\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "py":
							print $link . "<i class=\"fa-brands fa-python\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						case "apk":
							print $link . "<i class=\"fa-brands fa-android\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						// SETTINGS FILES
						case "exe":
							print $link . "<i class=\"fa-solid fa-gear\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
						default:
							print $link . "<i class=\"fa-solid fa-file\"></i>" . $tab . $value . "</a> | " . $dateformat . " | " . $filesize . " B<br>" . "<hr>";
							break;
					}
				}
			}
		}
	}