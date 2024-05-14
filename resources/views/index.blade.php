<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Record</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <x-app-layout>
    <x-slot name="header">記録アプリ</x-slot>
    </head>
        <body>
            
            <p class='body'>現在の時刻は 
           
            <div id="clock" class="clock"></div></p>
            
            <form method="POST" id="myForm">
                @csrf
                <input type="text"  name="event_name"  placeholder="イベント名を入力してください"><br />
                <button id="start" type="submit">開始する</button>
            </form>
            
            <div id="completionMessage" style="display:none;">保存が完了しました。</div>
            
            <form method="POST" id="stopForm" style="display: none;">
                @csrf
                <button id="stopButton" type="submit">停止する</button>
                <input type="submit" id="submit" value="保存">
            </form>
            
            <div id="stopfinishMessage" style="display:none;">作業が終了しました。</div>
                    
            <script>
                async function postData(url = '', data = {}) {
                    console.log("postData called");
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });
                    return await response.json();
                }
                async function editData(url = '', data = {}) {
                    console.log("editData called");
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });
                    return await response.json();
                }
                document.getElementById("myForm").addEventListener("submit", async function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);
                    try {
                        const response = await postData('/nakamura', Object.fromEntries(formData.entries()));
                        const completionMessage = document.getElementById("completionMessage");
                        completionMessage.style.display = "block";
                        document.getElementById("start").style.display = "none";
                        document.getElementById("stopForm").style.display = "block";
                        setTimeout(function() {
                            completionMessage.style.display = "none";
                        }, 3000);
                    } catch (error) {
                        console.error('エラー:', error);
                    }
                });
                document.getElementById("stopForm").addEventListener("submit", async function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);
                    try {
                        const response = await editData('/asuka', Object.fromEntries(formData.entries()));
                        const stopfinishMessage = document.getElementById("stopfinishMessage");
                        stopfinishMessage.style.display = "block";
                        document.getElementById("start").style.display = "block";
                        document.getElementById("stopForm").style.display = "none";
                        setTimeout(function() {
                            stopfinishMessage.style.display = "none";
                        }, 3000);
                    } catch (error) {
                        console.error('エラー:', error);
                    }
                });
            </script>
        </body>
    </x-app-layout>
</html>