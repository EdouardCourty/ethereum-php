# Change Log
All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/).

## [1.0.0] - 19-12-2024

Initial release of the project.

## [1.1.0] - 29-12-2024

Minor modifications to the project: <br />
- **Added** tests on `src/Client/EthereumClient` for better coverage
- **Deprecated** the `::getCurrentBlock` method in favor of the `::getCurrentBlockNumber` method for better readability and consistency
- **Fixed** the `::getPeerCount` method to correctly extract the value from the JSON-RPC response
