async function zapytajSerwer(skrypt,tresc = ""){
    const odpowiedz = await fetch("api",{
        method: "POST",
        headers: {"Authorization": skrypt},
        body: tresc
    })
    return await odpowiedz.text();
}