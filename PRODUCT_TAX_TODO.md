# Product Tax Transaction Type Implementation - TODO

## Completed Tasks
- [x] Database migration to add `transaction_type` column to `product_tax_mappings` table
- [x] Update Product model to include transaction type in pivot data
- [x] Update ProductController store method to handle transaction types
- [x] Update ProductController update method to handle transaction types
- [x] Update create product view to include transaction type selection
- [x] Update edit product view to include transaction type selection
- [x] Update show product view to display transaction types
- [ ] Update TaxCalculationService to respect transaction types
- [ ] Test the implementation with both sales and purchases
- [ ] Update documentation for the new feature

## Pending Tasks
- [ ] Update TaxCalculationService to respect transaction types
- [ ] Test the implementation with both sales and purchases
- [ ] Update documentation for the new feature

## Notes
- Transaction types: 'sale', 'purchase', 'both'
- Default transaction type: 'both'
- Need to ensure backward compatibility with existing data
