// This file will handle the content for Account Overview
function getContentForSection(fileName) {
    return `
        <div class="card">
            <h3>Balance</h3>
            <p>$1000</p>
        </div>
        <div class="card">
            <h3>Recent Transactions</h3>
            <ul>
                <li>Deposit: $1000 - 12/10/2024</li>
                <li>Withdrawal: $200 - 10/10/2024</li>
                <li>Transfer: $300 - 08/10/2024</li>
            </ul>
        </div>
    `;
}
