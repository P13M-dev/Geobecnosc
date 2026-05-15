async function zapytajSerwer(skrypt,tresc = ""){
    const odpowiedz = await fetch(`${window.location.origin}/api`,{
        method: "POST",
        headers: {"Authorization": skrypt},
        body: tresc
    })
    return await odpowiedz.text();
}