package com.example.jestem;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;

import java.util.Calendar;

public final class AlarmScheduler {

    public static final String ACTION_VERIFY_UPDATE = "VERIFY_UPDATE";
    private static final String PREFS = "app";
    private static final int REQUEST_CODE_6AM = 1001;

    private AlarmScheduler() {}

    public static void scheduleNext6AM(Context context) {
        SharedPreferences prefs = context.getSharedPreferences(PREFS, Context.MODE_PRIVATE);

        if (!prefs.getBoolean("verified", false)) {
            cancel6AM(context);
            return;
        }

        long triggerAt = getNext6AMMillis();

        AlarmManager alarmManager =
                (AlarmManager) context.getSystemService(Context.ALARM_SERVICE);

        if (alarmManager == null) return;

        Intent intent = new Intent(context, SixAMReceiver.class);
        intent.setAction("SIX_AM_ALARM");

        PendingIntent pi = PendingIntent.getBroadcast(
                context,
                REQUEST_CODE_6AM,
                intent,
                PendingIntent.FLAG_UPDATE_CURRENT | PendingIntent.FLAG_IMMUTABLE
        );

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.S && !alarmManager.canScheduleExactAlarms()) {
            alarmManager.setAndAllowWhileIdle(AlarmManager.RTC_WAKEUP, triggerAt, pi);
        } else {
            alarmManager.setExactAndAllowWhileIdle(AlarmManager.RTC_WAKEUP, triggerAt, pi);
        }

        prefs.edit().putLong("next6am", triggerAt).apply();
    }

    public static void cancel6AM(Context context) {
        AlarmManager alarmManager =
                (AlarmManager) context.getSystemService(Context.ALARM_SERVICE);

        if (alarmManager == null) return;

        Intent intent = new Intent(context, SixAMReceiver.class);
        intent.setAction("SIX_AM_ALARM");

        PendingIntent pi = PendingIntent.getBroadcast(
                context,
                REQUEST_CODE_6AM,
                intent,
                PendingIntent.FLAG_UPDATE_CURRENT | PendingIntent.FLAG_IMMUTABLE
        );

        alarmManager.cancel(pi);
    }

    public static void fireVerifyUpdate(Context context) {
        context.sendBroadcast(
                new Intent(ACTION_VERIFY_UPDATE).setPackage(context.getPackageName())
        );
    }

    private static long getNext6AMMillis() {
        Calendar cal = Calendar.getInstance();

        cal.set(Calendar.HOUR_OF_DAY, 6);
        cal.set(Calendar.MINUTE, 0);
        cal.set(Calendar.SECOND, 0);
        cal.set(Calendar.MILLISECOND, 0);

        if (cal.getTimeInMillis() <= System.currentTimeMillis()) {
            cal.add(Calendar.DAY_OF_YEAR, 1);
        }

        return cal.getTimeInMillis();
    }
}