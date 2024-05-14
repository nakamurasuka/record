<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // コントローラーのベースクラスを利用するために必要
use App\Models\Achievement; // Achievementモデルを利用するために必要

class AchievementController extends Controller
{
    public function index()
    {
        $achievement= Achievement::firstOrNew();
        return view('index', ['achievement' => $achievement]);
    }
    
    
    public function start(Request $request)
    {
        // バリデーションなど必要な処理を追加することもできます
        
        // Achievementモデルを使ってachievementsテーブルに保存する
        $achievement = new Achievement();
        $achievement->start_time = now();


        $achievement->date = now()->toDateString();

        
        $achievement->save();
        //$achievement->user_id 
        
        return response()->json(['success' => true]);
        
        

        
    }
    

    
    public function store(Request $request)
    {
        // バリデーションなどの処理を行う場合はここで行う
        $achievement = new Achievement();
        $achievement->event_name = $request->input('event_name');
        $achievement->current_date =now();
        $achievement->start_time =now();
        $achievement->save();
        return response()->json(['message' => 'データが追加されました'], 201);
    }
    
    public function stop(Request $request)
    {
        // `status`が`false`のレコードを取得
        $achievement = Achievement::where('status', 0)->first();

        if ($achievement) {
            // 現在の時刻を取得し、`end_time`にセット
            $achievement->end_time = now();
            
            // `status`を`true`に変更
            $achievement->status = true;
            
            // 取得したレコードの`start_time`を使用
            $startTime = $achievement->start_time;
            $endTime =  $achievement->end_time;// 現在の時刻
            
            // `start_time`と`end_time`の差分を計算（秒単位）
            $timeDiffInSeconds = strtotime($endTime) - strtotime($startTime);
            
            // 差分を分単位に変換
            $totalTime = floor($timeDiffInSeconds / 60); // 分単位の差分
            
            // `total_time`に差分をセット
            $achievement->total_time = $totalTime;
            
            // データベースに保存
            $achievement->save();
            
            return response()->json(['message' => 'Achievement updated successfully'], 201);
        } else {
            return response()->json(['message' => 'No achievement found with status false'], 404);
        }
    }
    
    
    
    // public function stop(Request $request)
    // {
    //     $achievement ->end_time = now();
    //     $achievement ->status = "true";
    //     // リクエストからstart_timeとend_timeを取得
    //     $startTime = $request->input('start_time');
    //     $endTime = $request->input('end_time');
        
    //     // start_timeとend_timeの差分を計算（秒単位）
    //     $timeDiffInSeconds = strtotime($endTime) - strtotime($startTime);
        
    //     // 差分を分単位に変換
    //     $totalTime = floor($timeDiffInSeconds / 60); // 分単位の差分
        
    //     $achievement->total_time = $totalTime;
        
        
        
    //     // 保存処理
        
    //     $achievement->save();
        
    //  }
     
     
}

