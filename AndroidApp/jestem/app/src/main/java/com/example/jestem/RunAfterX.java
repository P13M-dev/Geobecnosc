package com.example.jestem;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

import java.io.IOException;

public class RunAfterX extends BroadcastReceiver {
    @Override
    public void onReceive(Context context, Intent intent) {
        System.out.println("ZAKLADAMY ZE 6:00 STFU PIOTRZE");
        System.out.println(RequestsManager.post(
                "https://casino-lunacy-riveter.ngrok-free.dev/api",
                new Header[]{new Header("Authorization", "123456")}, new String[][] {})
        );
    }
}
