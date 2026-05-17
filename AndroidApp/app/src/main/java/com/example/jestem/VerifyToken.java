package com.example.jestem;

import static android.content.Context.MODE_PRIVATE;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;



public class VerifyToken extends BroadcastReceiver {

    SharedPreferences prefs;

    @Override
    public void onReceive(Context context, Intent intent) {
        System.out.println("TIMER MINAL");
        prefs = context.getSharedPreferences("app", MODE_PRIVATE);

        String data = RequestsManager.post(
                prefs.getString("domain", ""),
                new Header[]{new Header("Authorization", "zalogujUczen")},
                new String[][]{
                        {"email", prefs.getString("email", "")},
                        {"haslo", prefs.getString("password", "")},
                        {"token", prefs.getString("token", "")}
                }
        );

        SharedPreferences.Editor editor = prefs.edit();
        editor.putString("token", data);
        editor.putBoolean("verified", true);
        editor.apply();

        Intent updateIntent = new Intent(context, HomeActivity.class);

        updateIntent.addFlags(
                Intent.FLAG_ACTIVITY_NEW_TASK |
                Intent.FLAG_ACTIVITY_SINGLE_TOP |
                Intent.FLAG_ACTIVITY_CLEAR_TOP
        );

        context.startActivity(updateIntent);

        AlarmScheduler.fireVerifyUpdate(context);
        AlarmScheduler.scheduleNext6AM(context);
    }
}
