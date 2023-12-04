$(document).ready(function () {

  //változók
  var tableInfo = {};
  let url = "http://192.168.0.165:5000/api/";

  //funkciók
  // API lekérdezés
  function performAjaxRequest(url, method, data, successCallback, errorCallback) {
    $.ajax({
      url: url,
      method: method,
      data: data,
      success: function (response) {
        if (successCallback) {
          successCallback(response);
        }
      },
      error: function (error) {
        if (errorCallback) {
          errorCallback(error);
        }
      },
    });
  }
  // Hiba esetén meghívott függvény
  function handleError(error) {
    console.error("Hiba történt:", error);
  }
  // Tábla lekérdezések
  function tablesData(data) {
    // Táblainformációk tárolása az objektumban
    tableInfo = data;

    // A kapott táblainformációk feldolgozása és megjelenítése az oldalon
    var tables = tableInfo.tables;
    var projectSelector = $(".list-group");

    // Töröld az esetleges korábbi táblákat
    //projectSelector.empty();

    // Feltöltési logika
    tables.forEach(function (tableName) {
      var listItem = $("<li>", { class: "list-group-item" });
      listItem.text(tableName);

      //console.log(listItem)
      // Az adott táblára kattintva AJAX kérés indítása
      listItem.click(function () {
        var clickedTable = $(this).text();
        $(".kanban-column").empty();
        var apiUrl = "adatok?table=" + clickedTable;
        performAjaxRequest(url + apiUrl, "GET", '', cardData, handleError);
        console.log(
          "Lekérte"
        );
      })
      projectSelector.append(listItem);
    })
  }
  // Kártyák lekérdezése 
  function cardData(data) {
    // Az adatok feldolgozása és megjelenítése az oldalon
    // Változók a sorrendhez és számlálóhoz
    let backlogCounter = 0;
    let ongoingCounter = 0;
    let doneCounter = 0;

     // A kapott adatokat rendezzük növekvő sorrendbe a data-sn alapján


  // A rendezett adatok feldolgozása és kártyák létrehozása
    data.forEach(function (task) {
      // Kártya számlálók frissítése
      if (task.status === 0) {
        backlogCounter++;
      } else if (task.status === 1) {
        ongoingCounter++;
      } else if (task.status === 2) {
        doneCounter++;
      }

      // Kártya lábléce és ikonok hozzáadása
      let cardFooterHtml = `
          <div class="card-footer">
              ${getFooterButtons(task.status)}
          </div>
      `;

      // Kártya HTML létrehozása
      let cardHtml = `
        <div class="kanban-card card" draggable="true"
          data-id=${task.id} 
          data-status=${task.status} 
          data-sn=${task.serialNum} 
          data-user=${task.account}>
          <div class="card-header">${task.name}</div>
          <div class="card-body">
            Comment: ${task.comment}
            CR: ${task.start}
            Mod dat: ${task.mode}
          </div>
          ${cardFooterHtml}
        </div>
      `;

      // Az oszlophoz való hozzáadás a status mező alapján
      if (task.status === 0) {
        $(".kanban-column.backlog").append(cardHtml);
      } else if (task.status === 1) {
        $(".kanban-column.ongoing").append(cardHtml);
      } else if (task.status === 2) {
        $(".kanban-column.done").append(cardHtml);
      }
    });

    btnFuncs();
  }
  // Kártya láblécekben megjelenő ikonokat visszaadó függvény
  function getFooterButtons(status) {
    // Alapértelmezett ikonok minden gombhoz
    const arrowLeftIcon = '<i class="fas fa-arrow-left"></i>';
    const arrowRightIcon = '<i class="fas fa-arrow-right"></i>';
    const trashIcon = '<i class="fas fa-trash"></i>';
    const editIcon = '<i class="fas fa-edit"></i>';

    // Alapértelmezett láthatóság minden ikonnak
    let arrowLeftDisplay = "";
    let arrowRightDisplay = "";
    let trashDisplay = "";
    let editDisplay = "";

    // Állítsd be az ikonok láthatóságát a státusznak megfelelően
    if (status == 0) {
      arrowLeftDisplay = "none";
    } else if (status == 2) {
      arrowRightDisplay = "none";
    }

    // Visszaadjuk az összes gombot, minden ikonnal és láthatósággal
    return `
        <button class="btn btn-primary btn-sm move-left-button" style="display:${arrowLeftDisplay}">
            ${arrowLeftIcon}
        </button>
        <button class="btn btn-success btn-sm move-right-button" style="display:${arrowRightDisplay}">
            ${arrowRightIcon}
        </button>
        <button class="btn btn-danger btn-sm delete-button">
            ${trashIcon}
        </button>
        <button class="btn btn-secondary btn-sm edit-button">
            ${editIcon}
        </button>
    `;
  }
  // Eseménykezelők hozzáadása a gombokhoz
   //bunnton funkciók beállítása
  function btnFuncs() {
    let kanbanCards = document.querySelectorAll(".kanban-card");

    kanbanCards.forEach((card) => {
      const moveLeftButton = card.querySelector(".move-left-button");
      const moveRightButton = card.querySelector(".move-right-button");
      const deleteButton = card.querySelector(".delete-button");
      const editButton = card.querySelector(".edit-button");
      moveLeftButton.addEventListener("click", () => moveCardLeft(card));
      moveRightButton.addEventListener("click", () => moveCardRight(card));
      deleteButton.addEventListener("click", () => deleteCard(card));
      editButton.addEventListener("click", () => editCard(card));
    });
  }
  // Mozgatás balra gomb kártya funkció
  function moveCardLeft(card) {
    // Ellenőrizzük, hogy a kártya tartalmazza-e a "serialnum" adatot
    if (card.dataset.sn) {
      // Eltávolítjuk a kártyát az aktuális oszlopból
      const currentColumn = card.parentElement;
      currentColumn.removeChild(card);

      // Megkeressük az előző oszlopot
      const previousColumn = currentColumn.previousElementSibling;

      if (previousColumn) {
        // Beszúrjuk a kártyát az előző oszlop elejére
        previousColumn.insertBefore(card, previousColumn.firstChild);
        card.dataset.status = parseInt(card.dataset.status) - 1;
        if (card.dataset.status == 1)
          card.querySelector(".move-right-button").style.display = "";
        // Hozzáadjuk az "animate-move" osztályt a kártyához az animációhoz
        card.classList.add("animate-move").style.display = "none";;

        // Az előző oszlop elemeinek újraszámozása
        const cardsInPreviousColumn = previousColumn.querySelectorAll(".card");
        cardsInPreviousColumn.forEach((card, index) => {
          card.dataset.sn = index + 1;
        });
        // Várunk egy kis időt, majd eltávolítjuk az "animate-move" osztályt, hogy újra használhassuk
        setTimeout(() => {
          card.classList.remove("animate-move");
        }, 300); // A tranzíciós időhossz (300ms) után eltávolítjuk az osztályt
      }
    }
  }
  // Mozgatás jobbra gomb kártya funkció
  function moveCardRight(card) {
    // Ellenőrizzük, hogy a kártya tartalmazza-e a "serialnum" adatot
    // Eltávolítjuk a kártyát az aktuális oszlopból
    const currentColumn = card.parentElement;
    currentColumn.removeChild(card);

    // Megkeressük az előző oszlopot
    const nextElementSibling = currentColumn.nextElementSibling;

    if (nextElementSibling) {
      // Beszúrjuk a kártyát az előző oszlop elejére
      nextElementSibling.insertBefore(card, nextElementSibling.firstChild);
      card.dataset.status = parseInt(card.dataset.status) + 1;
      if (card.dataset.status == 1)
        card.querySelector(".move-left-button").style.display = "";
      else {
        card.querySelector(".move-right-button").style.display = "none";
      }

      // Az előző oszlop elemeinek újraszámozása
      const cardsInNextColumn = nextElementSibling.querySelectorAll(".card");
      cardsInNextColumn.forEach((card, index) => {
        card.dataset.sn = index + 1;
      });
    }
  }
  // Kártya törlése gomb kártya funkció
  function deleteCard(card) {

    // Létrehozunk egy modális elemet
    const modal = document.createElement("div");
    modal.className = "modal";

    // Hozzáadjuk a modális tartalmat
    modal.innerHTML = `
      <div class="modal-content">
        <p>Biztosan törölni szeretnéd a kártyát?</p>
        <div class="modal-buttons">
          <button id="confirm-delete">Igen</button>
          <button id="cancel-delete">Nem</button>
        </div>
      </div>
    `;

    // Az "Igen" gomb eseménykezelője
    const confirmDeleteButton = modal.querySelector("#confirm-delete");
    confirmDeleteButton.addEventListener("click", () => {
      // Töröljük a kártyát, ha "Igen"-re kattintottak
      deleteingCard(card);
      closeModal();
    });

    // A "Nem" gomb eseménykezelője
    const cancelDeleteButton = modal.querySelector("#cancel-delete");
    cancelDeleteButton.addEventListener("click", () => {
      // Bezárjuk a modált, ha "Nem"-re kattintottak
      closeModal();
    });

    // Hozzáadjuk a modált a dokumentumhoz
    document.body.appendChild(modal);

  }
  function deleteingCard(card) {
    // Töröljük a kártyát
    const currentColumn = card.parentElement;
    currentColumn.removeChild(card);
  }
  function closeModal() {
    // Kivesszük a modált a dokumentumból
    const modal = document.querySelector(".modal");
    modal.remove();
  }
  // Kártya szerkesztése gomb kártya funkció
  function editCard(card) {
    //console.log(card.querySelector(".card-body").innerHTML);

    // Létrehozunk egy modális elemet
    const modal = document.createElement("div");
    modal.className = "modal";

    const cardData = JSON.parse(JSON.stringify(card.dataset, null, 2));

    //console.log(cardData);
    // Létrehozunk egy HTML stringet a modal tartalmának
    let modalContent = '<div class="modal-content">';


   // console.log(card.querySelector(".card-body"))

    modalContent += `
    <div>
      <label>Név:</label>
      <input type="text" id="nev" value="${card.querySelector(".card-header").innerText}">
    </div>
    <div>
      <label>Komment:</label>
      <textarea id="comment">${card.querySelector(".card-body").innerText}</textarea>
    </div>
  `;

    // JSON értékeket soronként jelenítjük meg
    for (const key in cardData) {
      modalContent += `
    <div>
      <label>${key}:</label>
      <input type="text" id="${key}" value="${cardData[key]}">
    </div>
  `;
    }
   // console.log(modalContent)

    // Egy külön gomb az adatok mentéséhez
    modalContent += `
  <p>Biztosan módosítani szeretnéd a kártyát?</p>
  <div class="modal-buttons">
    <button id="confirm-edit">Módosítás</button>
    <button id="cancel-edit">Mégse</button>
  </div>
</div>`;

    modalContent += card.querySelector(".card-body");

    // Az elkészült modal tartalmat hozzáadjuk a modal elemhez
    modal.innerHTML = modalContent;

    // Az "Igen" gomb eseménykezelője
    const confirmEditButton = modal.querySelector("#confirm-edit");
    confirmEditButton.addEventListener("click", () => {
      // Töröljük a kártyát, ha "Igen"-re kattintottak
      const updatedData = {
        "database": "todo",
        "table_name": "tolna",
        "id": cardData.id,
        "account": modal.querySelector("#user").value,
        "status": modal.querySelector("#status").value,
        "serialNum": modal.querySelector("#sn").value,
       // "comment": modal.querySelector("#comment").value,
        "nev": modal.querySelector("#nev").value,
      }
       // Küldjük el az adatokat a szerverre
    fetch("http://127.0.0.1:5000/api/set_data", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(updatedData),
    })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      closeModal();
    })
    .catch(error => {
      console.error("Hiba történt:", error);
      closeModal();
    
    });
  });
    // A "Nem" gomb eseménykezelője
    const cancelEditButton = modal.querySelector("#cancel-edit");
    cancelEditButton.addEventListener("click", () => {
      // Bezárjuk a modált, ha "Nem"-re kattintottak
      closeModal();
    });

    document.body.appendChild(modal);
  }
  // DragNDrop
  // A kanban tábla oszlopokat tartalmazó tömb
  const columns = document.querySelectorAll(".kanban-column");

  // Eseményfigyelők hozzáadása a kártyákra a drag-and-drop funkcióhoz
  const cards = document.querySelectorAll(".kanban-card");
  cards.forEach((card) => {
    card.addEventListener("dragstart", dragStart);
    card.addEventListener("dragend", dragEnd);
  });
  // Eseményfigyelők hozzáadása az oszlopokhoz a kártyák fogadásához
  columns.forEach((column) => {
    column.addEventListener("dragover", dragOver);
    column.addEventListener("dragenter", dragEnter);
    column.addEventListener("dragleave", dragLeave);
    column.addEventListener("drop", drop);
  });
  // Drag-and-drop eseménykezelők
  let draggedCard = null; // A mozgatott kártya referencia
  function dragStart() {
    draggedCard = this;
    setTimeout(() => (this.style.display = "none"), 0);
  }
  function dragEnd() {
    setTimeout(() => (this.style.display = "block"), 0);
    draggedCard = null;
  }
  function dragOver(e) {
    e.preventDefault();
  }
  function dragEnter(e) {
    e.preventDefault();
    this.style.border = "2px dashed #007BFF";
  }
  function dragLeave() {
    this.style.border = "none";
  }
  function drop(e) {
    e.preventDefault();
    this.style.border = "none";

    // Ellenőrizd, hogy draggedCard egy érvényes DOM elem
    if (draggedCard && draggedCard.nodeType === 1) {
      this.appendChild(draggedCard);

      // Kártyák sorrendjének kiíratása a konzolba
      const columnId = this.getAttribute("class");
      const cardIds = Array.from(this.querySelectorAll(".kanban-card")).map(
        (card) => card.getAttribute("data-id")
      );
    // AJAX kérés küldése a performAjaxRequest függvénnyel
    performAjaxRequest(
      url + "/api/sort_data",
      "POST",
      JSON.stringify(requestData),
      function (response) {
        console.log("Sorrend frissítve az adatbázisban:", response.message);
      },
      handleError
    );
    }
  }
  //MAIN

  // AJAX hívás a táblainformációk lekérésére
  performAjaxRequest(url + "tables?database=todo", "GET", '', tablesData, handleError);
  performAjaxRequest(url + "adatok?table=code", "GET", '', cardData, handleError);

})
