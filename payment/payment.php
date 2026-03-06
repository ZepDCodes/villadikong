<h2>Pay with GCash</h2>
<p>Please send your payment to:</p>
<p><strong>GCash Number:</strong> 09XXXXXXXXX</p>
<img src="gcash_qr.png" alt="GCash QR" width="200">

<form action="upload_payment.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
    <label>Amount Paid:</label>
    <input type="number" step="0.01" name="amount" required><br><br>
    
    <label>GCash Reference Number:</label>
    <input type="text" name="reference_no" required><br><br>
    
    <label>Upload Proof of Payment:</label>
    <input type="file" name="proof_image" accept="image/*" required><br><br>
    
    <button type="submit">Submit Payment</button>
</form>