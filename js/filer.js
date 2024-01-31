const input = document.querySelector(".filter")
const allOneSeminar = document.querySelectorAll(".one-seminar")

const allOneStudentsArray = Array.from(allOneSeminars)
const allStudentsDiv = document.querySelector(".all-seminars")

// Studnts to Objects = pole Objektů
const studentsObjects = allOneSeminarsArray.map((oneSeminar, index) => {
    return {
        id: index,
        studentsName: oneSeminar.querySelector("h2").textContent,
        studentsLink: oneSeminar.querySelector("a")
    }
})

input.addEventListener("input", () => {
    const inputText = input.value.toLowerCase()

    const filterSeminars = seminarsObjects.filter( (oneSeminar) => {
        return oneSeminar.seminarsName.toLowerCase().includes(inputText)

    })

    //vymazat všechny ze stránky
    allSeminarsDiv.textContent =""

    filterSeminars.map( (oneFilterSeminar) => {
        const newDiv = document.createElement("div")
        newDiv.classList.add("one-seminar")

        const newH2 = document.createElement("h2")
        newH2.textContent = oneFilterSeminar.seminarsName
        newDiv.append(newH2)

        newDiv.append(oneFilterSeminar.seminarsLink)

        allSeminarsDiv.append(newDiv)
    })

})