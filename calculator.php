<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calculator JS</title>
    <link rel="stylesheet" href="calculator.css">
</head>
<body>

<div class="calculator">

</div>





<script>
    function Calculator() {
        this.expression = ""
        this.result = ""
        this.equalPressed = false

        this.makeExpression = function(expression) {
            if(this.expression === "" && this.isOperand(expression)) {
                console.log('first char cannot be symbol', expression)
                return false;
            }


            if( this.isOperand(this.expression.substr(-1)) && this.isOperand(expression) ) {
                console.log('cannot use operand together and last exp cannot be = ', this.expression);
                return false;
            }
            if(this.equalPressed === true && !isNaN(expression)) {
                this.expression = expression.toString()
                this.equalPressed = false
                return true;
            } else {
                this.equalPressed = false
            }

            if(expression === "=") {
                return true;
            }
            if(expression === "DEL") {
                console.log("expres is DEL", expression, "cu", this.expression)
                if(this.expression === "") { return this.result = ""; false }
                if(this.isOperand(this.expression.substr(-1))) {
                    console.log("ex", expression, "last", this.expression)
                    return "DEL-problem";
                } else {
                    return true;
                }
            }

            this.expression += expression

            if(this.isOperand(this.expression.substr(-1))) {
                console.log("it is valid but cannot be eval", this.expression)
                this.updateUI()
                return false
            }

            return true
        }
        this.calculateResult = function(e) {
            try {
                let currentValue = e.target.value
                let expression = this.makeExpression(currentValue)
                if(expression === true) {
                    this.result = eval(this.expression)
                    if(this.result === Infinity) {
                        this.result = "0"
                        this.expression = ""
                    }
                    this.updateUI()
                } else if( expression === "DEL-problem") {
                    if(this.expression.length > 0) {
                        this.result = eval(this.expression.slice(0,this.expression.length-1))
                        this.updateUI()
                    }
                }
                if(expression && currentValue === "=") {
                    this.expression = this.result.toString()
                    this.equalPressed = true;
                    this.updateUI()
                }
            } catch (e) {
                console.log(e);
            }
        }
        this.isOperand = function (val) {
            return val === "+" || val === "-" || val === "*" || val === "/" || val === "="
        }
        this.DELOneStep = function(e) {
            this.expression = this.expression.slice(0, this.expression.length-1);
            this.calculateResult.call(this, e);
            this.updateUI();
        }
        this.clearEverything = function() {
            this.expression = ""
            this.result = ""
            this.updateUI()
        }

        const calContainer = document.createElement('div')
        const resultArea = document.createElement('div')
        calContainer.classList.add('calculator-container')
        resultArea.classList.add('calculator-result-area')



        const calculatorUI = (() => {
            const cal = document.querySelector('.calculator')

            const operator = ["7","8","9","4","5","6","1","2","3",".","0","=","+","-","*","/","DEL","AC"]
            for(let i = 0; i < operator.length; i++) {
                let button = document.createElement('button')
                button.value = operator[i]
                button.innerText = operator[i];
                button.setAttribute('data-value', ""+ operator[i])
                cal.appendChild(button)
            }

            calContainer.appendChild(resultArea)
            calContainer.appendChild(cal)
            document.body.appendChild(calContainer)

            let calButtons = cal.querySelectorAll('button')
            for (let i = 0; i < calButtons.length; i++) {
                if(calButtons[i].value === "AC") {
                    calButtons[i].addEventListener('click', this.clearEverything.bind(this), false)
                } else if(calButtons[i].value === "DEL") {
                    calButtons[i].addEventListener('click', this.DELOneStep.bind(this), false)
                } else {
                    calButtons[i].addEventListener('click', this.calculateResult.bind(this), false)
                }
            }
        })()
        this.updateUI = function () {
            resultArea.innerHTML = `<div class="cal-result">${this.result}</div><div class="cal-expression">${this.expression}</div>`
        }



    }

    const calculator = new Calculator();

</script>
</body>
</html>