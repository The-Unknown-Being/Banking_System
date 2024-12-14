document.addEventListener("DOMContentLoaded", function() {
    const contentBody = document.getElementById("content-body");
    const links = document.querySelectorAll(".left-panel a");

    // Function to load content from the corresponding file
    function loadContent(contentType) {
        // Reset the content body
        contentBody.innerHTML = "<p>Loading...</p>";

        // Dynamically load the content for each section
        switch(contentType) {
            case 'account-overview':
                loadFileContent('../js/accountOverview.js');
                break;
            case 'transactions':
                loadFileContent('../js/transactions.js');
                break;
            case 'transfer-money':
                loadFileContent('../js/transferMoney.js');
                break;
            case 'pay-bills':
                loadFileContent('../js/payBills.js');
                break;
            case 'settings':
                loadFileContent('../js/settings.js');
                break;
            default:
                contentBody.innerHTML = "<p>Select a section to view content.</p>";
        }
    }

    // Function to fetch the content of the corresponding JavaScript file and execute it
    function loadFileContent(fileName) {
        const script = document.createElement('script');
        script.src = `${fileName}`;
        script.type = 'text/javascript';
        script.onload = function() {
            // After loading the script, run the content logic for that specific section
            contentBody.innerHTML = getContentForSection(fileName);
        };
        document.body.appendChild(script);
    }

    // Sample function to return the content of the section
    function getContentForSection(fileName) {
        let contentHTML = '';
        if (fileName === '../js/accountOverview.js') {
            contentHTML = `
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
        } else if (fileName === '../js/transactions.js') {
            contentHTML = `
                <h3>Transactions Overview</h3>
                <p>Here you can see all your past transactions.</p>
            `;
        } else if (fileName === '../js/transferMoney.js') {
            contentHTML = `
                <h3>Transfer Money</h3>
                <p>Option to transfer money to other accounts.</p>
            `;
        } else if (fileName === '../js/payBills.js') {
            contentHTML = `
                <h3>Pay Bills</h3>
                <p>Option to pay your utility bills.</p>
            `;
        } else if (fileName === '../js/settings.js') {
            contentHTML = `
                <h3>Settings</h3>
                <p>Manage your account settings here.</p>
            `;
        }
        return contentHTML;
    }

    // Set default content on page load
    loadContent("account-overview");

    // Event listeners for navigation links
    links.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            // Remove active class from all links
            links.forEach(link => link.classList.remove("active"));
            // Add active class to clicked link
            link.classList.add("active");
            // Update content based on the data-target attribute
            loadContent(link.getAttribute("data-target"));
        });
    });
});
