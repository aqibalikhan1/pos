// Define the currency symbol globally (will be fetched from backend)
let currencySymbol = '$'; // Default value, will be updated from backend

document.addEventListener('DOMContentLoaded', function() {
    const productSearch = document.getElementById('productSearch');
    const productResults = document.getElementById('productResults');
    const cartItems = document.getElementById('cartItems');
    const totalAmount = document.getElementById('totalAmount');
    const customerSelect = document.getElementById('customerSelect');
    const employeeSelect = document.getElementById('employeeSelect');
    const quickCreateCustomerBtn = document.getElementById('quickCreateCustomerBtn');
    const processSaleBtn = document.getElementById('processSaleBtn');

    let cart = [];
    let taxRates = []; // Store tax rates

    // Fetch currency symbol from backend
    fetchCurrencySymbol();
    // Fetch tax rates from backend
    fetchTaxRates();

    // Product search functionality
    productSearch.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        if (searchTerm.length > 2) {
            searchProducts(searchTerm);
        } else {
            productResults.innerHTML = '';
        }
    });

    // Quick create customer
    quickCreateCustomerBtn.addEventListener('click', function() {
        const name = prompt('Enter customer name:');
        if (name) {
            quickCreateCustomer(name);
        }
    });

    // Process sale
    processSaleBtn.addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Please add items to the cart first.');
            return;
        }

            if (!customerSelect.value || !employeeSelect.value) {
                alert('Please select a customer and an employee.');
                return;
            }

        processSale();
    });

    function searchProducts(searchTerm) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch('/pos/terminal/search-products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ search: searchTerm })
        })
        .then(response => response.json())
        .then(products => {
            displayProductResults(products);
        })
        .catch(error => console.error('Error:', error));
    }

    function displayProductResults(products) {
        productResults.innerHTML = '';
        if (products.length === 0) {
            productResults.innerHTML = '<p class="text-gray-500">No products found.</p>';
            return;
        }

        products.forEach(product => {
            const productElement = document.createElement('div');
            productElement.className = 'product-item p-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100';
            productElement.innerHTML = `
                <div class="flex justify-between items-center">
                    <div>
                        <strong>${product.name}</strong>
                        <p class="text-sm text-gray-600">SKU: ${product.sku || 'No SKU'}</p>
                        <p class="text-sm text-gray-600">${product.category?.name || 'No Category'}</p>
                        <p class="text-sm text-gray-600">Stock: ${product.stock_quantity}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-semibold">${currencySymbol}${parseFloat(product.price).toFixed(2)}</p>
                        <button class="add-to-cart-btn mt-1 bg-blue-600 text-white px-2 py-1 rounded text-sm hover:bg-blue-700"
                                data-product-id="${product.id}"
                                data-product-name="${product.name}"
                                data-product-price="${product.price}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;
            productResults.appendChild(productElement);
        });

        // Add event listeners to add-to-cart buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productPrice = parseFloat(this.getAttribute('data-product-price'));
                addToCart(productId, productName, productPrice);
            });
        });
    }

    function addToCart(productId, productName, productPrice) {
        const existingItem = cart.find(item => item.productId === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                productId: productId,
                name: productName,
                price: productPrice,
                quantity: 1
            });
        }
        
        updateCartDisplay();
    }

    function updateCartDisplay() {
        cartItems.innerHTML = '';
        let total = 0;
        let totalDiscount = 0; // Initialize total discount
        let totalExclTax = 0; // Initialize total excluding tax
        let totalTaxAmount = 0; // Initialize total tax amount
        let totalGrossAmount = 0; // Initialize total gross amount

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            // Calculate discounts
            const discount = 0; // Placeholder for discount logic
            const amountExclTax = itemTotal - discount;
            
            // Calculate tax using actual tax rates from backend
            let itemTaxAmount = 0;
            taxRates.forEach(taxRate => {
                itemTaxAmount += (amountExclTax * taxRate.rate / 100);
            });
            
            const grossAmount = amountExclTax + itemTaxAmount;

            totalDiscount += discount;
            totalExclTax += amountExclTax;
            totalTaxAmount += itemTaxAmount;
            totalGrossAmount += grossAmount;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-2">${item.name}</td>
                <td class="px-4 py-2">
                    <input type="number" value="${item.quantity}" min="1" 
                           class="quantity-input w-16 border rounded px-2 py-1"
                           data-index="${index}">
                </td>
                <td class="px-4 py-2">${currencySymbol}${item.price.toFixed(2)}</td>
                <td class="px-4 py-2">${currencySymbol}${itemTotal.toFixed(2)}</td>
                <td class="px-4 py-2">${currencySymbol}${discount.toFixed(2)}</td>
                <td class="px-4 py-2">${currencySymbol}${amountExclTax.toFixed(2)}</td>
                <td class="px-4 py-2">${currencySymbol}${itemTaxAmount.toFixed(2)}</td>
                <td class="px-4 py-2">${currencySymbol}${grossAmount.toFixed(2)}</td>
                <td class="px-4 py-2">
                    <button class="remove-item-btn bg-red-600 text-white px-2 py-1 rounded text-sm hover:bg-red-700"
                            data-index="${index}">
                        Remove
                    </button>
                </td>
            `;
            cartItems.appendChild(row);
        });

        // Update total amount to include tax
        totalAmount.textContent = `${currencySymbol}${totalGrossAmount.toFixed(2)}`;

        // Add event listeners
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const index = parseInt(this.getAttribute('data-index'));
                const newQuantity = parseInt(this.value);
                if (newQuantity > 0) {
                    cart[index].quantity = newQuantity;
                    updateCartDisplay();
                }
            });
        });

        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                cart.splice(index, 1);
                updateCartDisplay();
            });
        });
    }

    function quickCreateCustomer(name) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch('/pos/terminal/quick-create-customer', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add the new customer to the select dropdown
                const option = document.createElement('option');
                option.value = data.customer.id;
                option.textContent = data.customer.name;
                customerSelect.appendChild(option);
                customerSelect.value = data.customer.id;
                alert('Customer created successfully!');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function processSale() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        // Calculate total amount and tax amounts
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.quantity;
        });
        
        const taxAmount = calculateTaxAmount(total);
        const totalWithTax = total + taxAmount;

        const saleData = {
            customer_id: customerSelect.value,
            employee_id: employeeSelect.value, // Use the selected employee ID
            items: cart.map(item => ({
                product_id: item.productId,
                quantity: item.quantity,
                unit_price: item.price
            })),
            tax_rates: taxRates.map(taxRate => ({
                tax_rate_id: taxRate.id,
                rate: taxRate.rate,
                amount: (total * taxRate.rate / 100)
            })),
            payment_method: 'cash', // You can add payment method selection
            paid_amount: parseFloat(totalAmount.textContent.replace(currencySymbol, '')),
            total_amount: total,
            tax_amount: taxAmount,
            total_with_tax: totalWithTax,
            notes: ''
        };

        fetch('/pos/terminal/process-sale', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(saleData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Sale processed successfully!');
                // Clear cart and reset
                cart = [];
                updateCartDisplay();
                customerSelect.value = '';
                productSearch.value = '';
                productResults.innerHTML = '';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the sale.');
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F2') {
            productSearch.focus();
            e.preventDefault();
        }
    });

    // Function to fetch currency symbol from backend
    function fetchCurrencySymbol() {
        fetch('/pos/terminal/currency-symbol')
            .then(response => response.json())
            .then(data => {
                if (data.symbol) {
                    currencySymbol = data.symbol;
                    console.log('Currency symbol set to:', currencySymbol);
                }
            })
            .catch(error => {
                console.error('Error fetching currency symbol:', error);
            });
    }

    // Function to fetch tax rates from backend
    function fetchTaxRates() {
        fetch('/pos/terminal/tax-rates')
            .then(response => response.json())
            .then(data => {
                if (data.taxRates) {
                    taxRates = data.taxRates;
                    console.log('Tax rates set to:', taxRates);
                }
            })
            .catch(error => {
                console.error('Error fetching tax rates:', error);
            });
    }

    // Function to calculate tax amount for each item
    function calculateTaxAmount(itemTotal) {
        let totalTax = 0;
        taxRates.forEach(taxRate => {
            totalTax += (itemTotal * taxRate.rate / 100);
        });
        return totalTax;
    }
});
