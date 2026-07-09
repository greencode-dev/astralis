import '@testing-library/jest-dom';

class MockIntersectionObserver {
    constructor(callback) {
        this.callback = callback;
    }
    observe() {}
    unobserve() {}
    disconnect() {}
    takeRecords() {
        return [];
    }
}
window.IntersectionObserver = MockIntersectionObserver;
