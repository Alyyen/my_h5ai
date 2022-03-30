$(document).ready(function () {
    // SEARCHBAR
    $('#searchbar').keyup(function (e) {
        e.preventDefault();
        $('#answer-searchbar').empty();

        // GET THE LETTERS SENT IN THE INPUT
        let $search = document.querySelector('#searchbar').value;

        // GET CONTENT OF THE ARRAY
        let i;
        let $arr = document.querySelector('#array');
        let $tmp = $arr.getElementsByTagName("a");
        let $count = $arr.getElementsByTagName("a").length;
        for (i = 0; i < $count; i++) {
            let $value = $tmp[i]['text'];
            $value = $value.trim();
            if ($value.includes($search)) {
                if ($value.includes('.')) {

                    $('#answer-searchbar').append("&nbsp<a data-dismiss=\"modal\" data-toggle=\"modal\" data-target=\"#modal-file-open\" href=\"#modal-file-open\" class='btn file-to-open'>" + $value + "</a><br>");

                    $('.file-to-open').click(function (e) {
                        // CLEAR MODAL
                        $("#modal-file-content").empty();
                        $("#modal-title").empty();

                        // MODIFY CONTENT
                        $("#modal-title").append($(this).text());

                        let filepath = $value.replace(/\s+/g, '');
                        let url = window.location.href + "/" + filepath;
                        let urlCleared = url.replace("http://" + window.location.host, '');

                        $.get(urlCleared, function (data) {
                            $("#modal-file-content").append(data);

                            // DOWNLOAD
                            $("#dl-content-btn").click(function () {
                                download($value, data);
                            })
                        }, "text");
                    })
                } else {
                    if (i !== 0) {
                        console.log('folder');
                        $('#answer-searchbar').append("&nbsp<a href=\"" + window.location + "/" + $value + "\" class='btn array-folder'><i class=\"fa-solid fa-folder\"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + $value + "</a><br>");
                    } else {
                        console.log('source');
                    }
                }
            } else {
                console.log('KO');
            }
        }
    })

    // FILE MODAL
    $('.file-to-open').click(function (e) {
        let file = $(this).text();
        let filepath = file.replace(/\s+/g, '');
        let url = window.location.href + "/" + filepath;
        let urlCleared = url.replace("http://" + window.location.host, '');

        // CLEAR MODAL
        $("#modal-file-content").empty();
        $("#modal-title").empty();

        // GET FILE EXTENSION
        let ext = $(this).text().split('.').pop();

        // CONTENT
        switch (ext) {
            case "txt":
            case "html":
            case "css":
            case "java":
            case "py":
            case "js":
            case "php":
                // TEXT
                $("#modal-title").append($(this).text());

                $.get(urlCleared, function (data) {
                    $("#modal-file-content").append(data);

                    // DOWNLOAD
                    $("#dl-content-btn").click(function () {
                        download(file, data);
                    })
                }, "text");
                break;
            case "png":
            case "jpeg":
            case "jpg":
            case "bmp":
            case "gif":
            case "ico":
            case "svg":
            case "pdf":
                // IMAGE
                $("#modal-title").append($(this).text());

                // DISPLAY IMAGE
                $.get(urlCleared, function () {
                    let img_file = document.createElement("img");
                    img_file.src = urlCleared;
                    img_file.alt = filepath;
                    $("#modal-file-content").append(img_file);

                    // DOWNLOAD
                    $("#dl-content-btn").click(function () {
                        download_img(urlCleared, filepath);
                    })
                }, "text");
                break;
            case "mp3":
                $("#modal-title").append($(this).text());
                // DISPLAY AUDIO
                $.get(urlCleared, function () {
                    let audio_file      = document.createElement("audio");
                    audio_file.src      = urlCleared;
                    audio_file.id       = 'audio-player';
                    audio_file.controls = 'controls';
                    audio_file.type     = 'audio/mpeg';
                    $("#modal-file-content").append(audio_file);

                    // DOWNLOAD
                    $("#dl-content-btn").click(function () {
                        download_img(urlCleared, filepath);
                    })
                }, "text");
                break;
            case "mp4":
                $("#modal-title").append($(this).text());
                // DISPLAY VIDEO
                $.get(urlCleared, function () {
                    let video_file      = document.createElement("video");
                    video_file.src      = urlCleared;
                    video_file.id       = 'video-player';
                    video_file.autoplay = false;
                    video_file.controls = true;
                    video_file.muted    = false;

                    $("#modal-file-content").append(video_file);

                    // DOWNLOAD
                    $("#dl-content-btn").click(function () {
                        download_img(urlCleared, filepath);
                    })
                }, "text");
                break;
            default:
                $("#modal-title").append($(this).text());
                $.get(urlCleared, function (data) {
                    $("#modal-file-content").append(data);

                    // DOWNLOAD
                    $("#dl-content-btn").click(function () {
                        download(file, data);
                    })
                }, "text");
                break;
        }
    })

    // DOWNLOAD FUNCTION
    function download(filename, text) {
        let element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }

    // DOWNLOAD MEDIAS
    function download_img(filepath, filename) {
        let element = document.createElement('a');
        element.setAttribute('href', filepath);
        element.setAttribute('download', filename);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }
});