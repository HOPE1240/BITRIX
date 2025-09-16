<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <script src="//api.bitrix24.com/api/v1/"></script>
    <div id="dealIdInfo"></div>
    <button id="openPanelBtn">Abrir panel</button>
    <script>
        BX24.init(function(){
            BX24.placement.info(function(ctx){
                const dealId = ctx.options?.ID || '';
                document.getElementById('dealIdInfo').textContent = 'Deal ID: ' + dealId;

                document.getElementById('openPanelBtn').onclick = function() {
                    const url = location.origin + '/public/index.php?dealId=' + encodeURIComponent(dealId);
                    try {
                        (window.top.BX?.SidePanel?.Instance || BX24.slider).open(url, { width: 1200 });
                    } catch (e) {
                        alert('Error al abrir el panel: ' + e.message);
                    }
                };
            });
        });
    </script>
</body>
</html>