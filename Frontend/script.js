async function zapytajSerwer(skrypt,tresc = ""){
    const response = await fetch("api",{
        method: "POST",
        headers: {"Authorization": auth},
        body: params
    })
    return await response.text();
}