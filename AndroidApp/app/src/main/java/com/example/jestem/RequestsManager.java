package com.example.jestem;

import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class RequestsManager {

    public static String post(String url, Header[] headers, String[][] data) {

        final String[] result = {null};

        Thread thread = new Thread(() -> {

            try {

                OkHttpClient client = new OkHttpClient();

                FormBody.Builder bodyBuilder = new FormBody.Builder();

                for (String[] field : data) {
                    bodyBuilder.add(field[0], field[1]);
                }

                RequestBody body = bodyBuilder.build();

                Request.Builder builder = new Request.Builder()
                        .url(url)
                        .post(body);

                for (Header header : headers) {
                    builder.header(header.header, header.value);
                }

                Request request = builder.build();

                Response response = client.newCall(request).execute();

                result[0] = response.body().string();

            } catch (Exception e) {
                e.printStackTrace();
            }

        });

        thread.start();

        try {
            thread.join();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }

        return result[0];
    }
}
