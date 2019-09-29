/* code to calculate the budget */

const addBudgetForm = document.getElementById("budgetform");
const budgetResponseMessage = document.getElementById("budgetResponseMessage");
const expenseResponseMessage = document.getElementById(
  "expenseResponseMessage"
);
const addedBudgetResponseMessage = document.getElementById(
  "addedBudgetResponseMessage"
);


const addExpenseForm = document.querySelector("#expenseform");
const calculateBtn = document.getElementById("calculate");
const table = document.getElementById("table");

const expenseArray = [];
let Budget = {};
let userBudget;
let totalBudget;
let balance;

//  Adding New Net income
addBudgetForm.addEventListener("submit", event => {
  event.preventDefault();
  userBudget = document.getElementById("userbudget").value;

  if (userBudget < 0 || userBudget === "" || userBudget === null) {
    budgetResponseMessage.append("Please, enter a valid Net Income.");
    setTimeout(function() {
      budgetResponseMessage.remove();
      addBudgetForm.reset();
    }, 2000);
    // setTimeout(function () {
    //   budgetResponseMessage.append('Please, enter a valid budget.'), 1000);
    // budgetResponseMessage.append('Please, enter a valid budget.');
  } else {
    budgetResponseMessage.textContent = null;
    // send Success Message
    addedBudgetResponseMessage.append($('#userbudget').val());
    document.getElementById("userbudget").setAttribute("readonly", true);
    document.getElementById("budgetButton").setAttribute("disabled", true);

    // initiate new budget
    const budgetValue = parseInt(userBudget);
    Budget.totalBudget = budgetValue;
  }
});

//   Adding New Expense
addExpenseForm.addEventListener("submit", event => {
  event.preventDefault();

  let expenseName = document.querySelector("#expensename").value;
  const priorities = document.querySelector("#priorities");
  let priority = priorities.options[priorities.selectedIndex].value;
  console.log(expenseName);
  console.log(priority);

  if (expenseName.length < 2 || expenseName === "") {
    expenseResponseMessage.append("Please, Enter a valid Budget title.");
  } else {
    const newExpense = { expenseName, priority };
    expenseArray.push(newExpense);
    expenseResponseMessage.textContent = null;
    // Send Success MEssage
    addedExpenseResponseMessage.append(`Added "${expenseName}" to Budget.`);
    // console.log(expenseArray);

    expenseName = document.querySelector("#expensename");
    expenseName.value = null;
    expenseName = null;

    setTimeout(function() {
      addedExpenseResponseMessage.textContent = null;
    }, 1000);
  }
});

// Calculate Budget
const calculateBudget = async () => {
  let totalPriority = 0;
  let totalInversePriority = 0;
  let totalFundAllocated = 0;

  await expenseArray.map(expense => {
    totalPriority = eval(parseInt(totalPriority) + parseInt(expense.priority));
  });

  await expenseArray.map(expense => {
    expense.inversePriority = eval(parseInt(totalPriority) - expense.priority);
  });

  await expenseArray.map(expense => {
    totalInversePriority = eval(
      parseInt(totalInversePriority) + parseInt(expense.inversePriority)
    );
  });

  await expenseArray.map(expense => {
    expense._id = expense.expenseName.trim().slice(0, 2);
  });

  await expenseArray.map(expense => {
    const { inversePriority } = expense;
    // console.log(inversePriority, totalPriority);
    calculateFundAllocated = Math.floor(
      eval(
        (parseInt(inversePriority) / parseInt(totalInversePriority)) *
          parseInt(Budget.totalBudget)
      )
    );
    const FundsAllocated = roundDown(calculateFundAllocated, 100);
    totalFundAllocated = eval(
      parseInt(totalFundAllocated) + parseInt(FundsAllocated)
    );

    const styledFundsAllocated = FundsAllocated.toLocaleString();
    expense.fundAllocated = styledFundsAllocated;
  });
  balance = eval(parseInt(Budget.totalBudget) - parseInt(totalFundAllocated));
  renderExpenses(expenseArray, balance);

  return;
};

// Start Calculating
calculateBtn.addEventListener("click", calculateBudget);

const renderExpenses = (array, balance) => {
  for (expense in array) {
    const tr = document.createElement("tr");
    // let _id = array[expense].expenseName.slice(0 , 1);
    // console.log(array[expense]);
    tr.innerHTML = `
    <td> ${array[expense].expenseName}  </td>
    <td> ${array[expense].priority}  </td>
    <td> ₦ ${array[expense].fundAllocated}  </td>
    <hr>
    `;
    // console.log(tr);

    table.append(tr);
    // _id = " "
    // alert(balance)
    // console.log(array[expense]);
  }
  if (balance) {
    const tr = document.createElement("tr");

    tr.innerHTML = `
    <td> </td>
    <td> <b> BALANCE </b>  </td>
    <td> ₦ ${balance}  </td>`;

    table.append(tr);
  } else {
    // Do nothing ;
  }
};

const roundDown = (num, precision) => {
  num = parseFloat(num);
  if (!precision) return num.toLocaleString();
  return Math.floor(num / precision) * precision;
};

// const toggle = document.querySelector(".toggle");
// let items = document.querySelectorAll(".item");

// toggle.addEventListener("click", function() {
//   items.forEach(item => {
//     if (item.style.display == "") {
//       item.style.display = "block";
//     } else {
//       item.style.display = "";
//     }
//   });
// });

//  the code above is for the nav bar
