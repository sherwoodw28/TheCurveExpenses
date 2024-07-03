<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form - The Curve</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="/assets/expense_form/style.css">
</head>
<body>
    <div class="container">
        <h2>Approval Form</h2>
        <form id="form">
            <p id="message"></p>
            <label for="reason">Reason for Request: <span style="color: red;">*</span></label>
            <input type="text" id="reason" name="reason" required>
            
            <label for="details">Full Details of Request: <span style="color: red;">*</span><br>(starting location, destination time, transport required, etc)</label>
            <input type="text" id="details" name="details" required>

            <label for="dateNeededFrom">Date Required from: <span style="color: red;">*</span> (dd/mm/yyyy)</label>
            <input type="date" id="dateNeededFrom" name="dateNeededFrom" required>

            <label for="dateNeededTo">End date: <span style="color: red;">*</span> (dd/mm/yyyy)</label>
            <input type="date" id="dateNeededTo" name="dateNeededTo" required>

            <label for="totalCost">Total Cost: <span style="color: red;">*</span> (only applicable to Employees directly making the booking)</label>
            <input type="number" id="totalCost" name="totalCost" required>

            <label for="fileUpload">Please upload all receipts: <span style="color: red;">*</span></label>
            <input type="file" id="fileUpload" name="fileUpload" required>

            <label for="fileUpload1">Please upload all receipts:</label>
            <input type="file" id="fileUpload1" name="fileUpload1">

            <label for="fileUpload2">Please upload all receipts:</label>
            <input type="file" id="fileUpload2" name="fileUpload2">

            <label for="assistance">Do you require assistance with your booking? <span style="color: red;">*</span> (including making the payment)</label>
            <select id="assistance" name="assistance" required>
                <option value="0" selected>No</option>
                <option value="1">Yes</option>
            </select>

            <label for="comments">Any additional comments?</label>
            <input type="text" id="comments" name="comments">

            <button type="submit">Submit</button>
        </form>
    </div>
    <script src="/assets/expense_form/script.js"></script>
</body>
</html>