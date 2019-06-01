<?php
#session_start();

if(!$_SESSION['login_email'])
{
echo "You are not logged in";
exit();
}
require '../../includes/config.php';

$login_email = $_SESSION['login_email'];

$sql = "SELECT * FROM members WHERE email='".$login_email."'";
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $my_number=$row['number'];
    $my_name=$row['name'];
    $my_contribution_weeks=$row['weeks_to_contribute'];
}

$sql = "SELECT SUM(amount),SUM(amount)*0.001066667 FROM contributions"; //Since 2 members had leaves of 34 weeks each %rate = SUM(amount)/((99*5+65*2)*150)*100 									//If no Leave by members then %rate=SUM(amount)/(99*7*150)*100
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $overall_contribution_rate=$row['SUM(amount)*0.001066667']; //0.001066667=SUM(amount)/((99*5+65*2)*150)*100 
    $overall_contribution=$row['SUM(amount)'];
}

$sql = "SELECT SUM(loanamount) ,SUM(amount_to_return),SUM(amount_returned) FROM loans;"; 
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $amount_to_return=$row['SUM(amount_to_return)'];
    $amount_returned = $row['SUM(amount_returned)'];
}

$sql = "SELECT SUM(amount) FROM otherexpenses;"; 
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $other_expenses=$row['SUM(amount)']; 
}

$sql = "SELECT SUM(amount),($my_contribution_weeks*150)-SUM(amount) FROM contributions WHERE number=$my_number;"; 
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $my_contribution=$row['SUM(amount)'];
    $my_contribution_balance=$my_contribution_weeks*150-$my_contribution;
    $my_percentage_contribution=$my_contribution/($my_contribution_weeks*150)*100;
}

$sql = "SELECT SUM(loanamount),SUM(balance),SUM(amount_returned) FROM loans;"; 
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $overall_loan_amount=$row['SUM(loanamount)'];
    $overall_loan_balance=$row['SUM(balance)'];//not used anywhere
    $overall_loan_amount_returned=$row['SUM(amount_returned)'];
}

$sql = "SELECT SUM(amount),SUM(transcharge) FROM disbursment;"; 
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $overall_disbursment=$row['SUM(amount)'];
    $overall_disbusement_transaction=$row['SUM(transcharge)'];
}

$sql = "SELECT SUM(balance) FROM loans WHERE number=$my_number AND balance>0";
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)){ 
    $my_loanbalance=$row['SUM(balance)'];
}

$amount_available = $overall_contribution-$overall_disbursment-$overall_disbusement_transaction-$other_expenses-$overall_loan_balance;

