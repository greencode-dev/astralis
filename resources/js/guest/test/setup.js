import '@testing-library/jest-dom';

class MockIntersectionObserver {
    constructor(callback) {
        this.callback = callback;
        queueMicrotask(() => {
            callback([{ isIntersecting: true, target: document.createElement('div') }]);
        });
    }
    observe() {}
    unobserve() {}
    disconnect() {}
    takeRecords() {
        return [];
    }
}
window.IntersectionObserver = MockIntersectionObserver;
