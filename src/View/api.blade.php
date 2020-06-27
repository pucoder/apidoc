<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ json_decode(file_get_contents(base_path('apidoc.json')), true)['title'] }}</title>
</head>
<body style="padding: 0;margin: 0;border: 0;overflow: hidden;">
<iframe src="/apidoc/index.html" id="iframe" frameborder="0" width="100%" height="100%" scrolling="yes" marginheight="0" marginwidth="0"></iframe>
<script type="text/javascript">
    window.onload = function() {
        let height = calcPageHeight(document);
        parent.document.getElementById('iframe').style.height = height + 'px';
    }

    function calcPageHeight(doc) {
        let cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight);
        let sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight);
        return  Math.max(cHeight, sHeight);
    }
</script>
</body>
</html>
