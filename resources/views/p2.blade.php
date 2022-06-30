<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Player </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="{{asset("./js/app.js")}}"></script>
    <h1 id="u">player 2</h1>
    <div class="board" id="board">
        <div class="cell" data-cell pos="11"></div>
        <div class="cell" data-cell pos="12"></div>
        <div class="cell" data-cell pos="13"></div>
        <div class="cell" data-cell pos="21"></div>
        <div class="cell" data-cell pos="22"></div>
        <div class="cell" data-cell pos="23"></div>
        <div class="cell" data-cell pos="31"></div>
        <div class="cell" data-cell pos="32"></div>
        <div class="cell" data-cell pos="33"></div>
      </div>
      <div class="winning-message" id="winningMessage">
        <div data-winning-message-text></div>
        <button id="restartButton">Restart</button>
      </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    const X_CLASS = 'o'
    const CIRCLE_CLASS = 'x'
    const WINNING_COMBINATIONS = [
      [0, 1, 2],
      [3, 4, 5],
      [6, 7, 8],
      [0, 3, 6],
      [1, 4, 7],
      [2, 5, 8],
      [0, 4, 8],
      [2, 4, 6]
    ]
    const cellElements = document.querySelectorAll('[data-cell]')
    const board = document.getElementById('board')
    const winningMessageElement = document.getElementById('winningMessage')
    const restartButton = document.getElementById('restartButton')
    const winningMessageTextElement = document.querySelector('[data-winning-message-text]')
    let circleTurn
    
    startGame()
    
    restartButton.addEventListener('click', startGame)
    
    function startGame() {
      circleTurn = true
      cellElements.forEach(cell => {
        cell.classList.remove(X_CLASS)
        cell.classList.remove(CIRCLE_CLASS)
        cell.removeEventListener('click', handleClick)
        cell.addEventListener('click', handleClick, { once: true })
      })
      setBoardHoverClass()
      winningMessageElement.classList.remove('show')
    }
    
    function handleClick(e) {
      const cell = e.target
      pos = $(e.target).attr("pos")
      const currentClass = circleTurn ? CIRCLE_CLASS : X_CLASS
      placeMark(cell, currentClass)
      if (checkWin(currentClass)) {
        sendUpodate()
        endGame(false)
      } else if (isDraw()) {
        sendUpodate()
        endGame(true)
      } else {
        swapTurns()
        setBoardHoverClass()
        sendUpodate()
      }
      function sendUpodate(){
        $.ajax({
        url: '{{route("playground")}}',
        type: "POST",
        data: { "_token": "{{ csrf_token() }}", "pos": currentClass+pos }
      }).done(function(data){
        console.log("success" + data);
      }).fail(function(jqXHR, status, err){
        console.log("fail" + err);
      });
      }
    }
    
    function endGame(draw) {
      if (draw) {
        winningMessageTextElement.innerText = 'Draw!'
      } else {
        winningMessageTextElement.innerText = `${!circleTurn ? "O's" : "X's"} Wins!`
      }
      winningMessageElement.classList.add('show')
    }
    
    function isDraw() {
      return [...cellElements].every(cell => {
        return cell.classList.contains(X_CLASS) || cell.classList.contains(CIRCLE_CLASS)
      })
    }
    
    function placeMark(cell, currentClass) {
      cell.classList.add(currentClass)
    }
    
    function swapTurns() {
      circleTurn = !circleTurn
    }
    
    function setBoardHoverClass() {
      board.classList.remove(X_CLASS)
      board.classList.remove(CIRCLE_CLASS)
      if (circleTurn) {
        board.classList.add(CIRCLE_CLASS)
      } else {
        board.classList.add(X_CLASS)
      }
    }
    
    function checkWin(currentClass) {
      return WINNING_COMBINATIONS.some(combination => {
        return combination.every(index => {
          return cellElements[index].classList.contains(currentClass)
        })
      })
    }
      </script>
</html>