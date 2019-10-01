const budgetAmt = document.querySelector('#budget-amount');
const userbudget= document.querySelector('#userbudget');

$budget_item_amt = userbudget.addEventListener('change', e => {

                      budgetAmt.textContent = userbudget.value;
                   });