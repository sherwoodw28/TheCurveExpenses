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
        <form id="sampleForm">
            
            <label for="reason">Reason for Request:</label>
            <input type="reason" id="reason" name="reason" required>
            
            <label for="details">Full Details of Request: <br>(starting location, destination time, transport required, etc)</label>
            <input type="details" id="details" name="details" required>

            <label for="dateNeededFrom">Date Required from: (dd/mm/yyyy)</label>
            <input type="dateNeededFrom" id="dateNeededFrom" name="dateNeededFrom" required>

            <label for="dateNeededTo">End date: (dd/mm/yyyy)</label>
            <input type="dateNeededTo" id="dateNeededTo" name="dateNeededTo" required>

            <label for="totalCost">Total Cost: (only applicable to Employees directly making the booking)</label>
            <input type="totalCost" id="totalCost" name="totalCost" required>

            <label for="fileUpload">Please upload all receipts:</label>
            <input type="file" id="fileUpload" name="fileUpload" required>

            <label for="fileUpload">Please upload all receipts:</label>
            <input type="file" id="fileUpload1" name="fileUpload1" required>

            <label for="fileUpload">Please upload all receipts:</label>
            <input type="file" id="fileUpload2" name="fileUpload2" required>

            <label for="assistance">Do you require assistance with your booking? (including making the payment)</label>
            <select id="assistance" name="assistance" required>
                <option value="">Select an option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>

            <label for="comments">Any additional comments?</label>
            <input type="comments" id="comments" name="comments" required>

            <button type="submit">Submit</button>
        </form>
    </div>
    <script src="/assets/expense_form/script.js"></script>
</body>
</html>