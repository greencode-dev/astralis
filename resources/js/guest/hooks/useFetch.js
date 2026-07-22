// Custom hook: useReducer + AbortController. Gestisce loading/error/data. Cleanup su unmount
import { useReducer, useEffect } from 'react';
import axios from 'axios';

// fetchReducer: 3 azioni — START (loading), SUCCESS (data), ERROR (error)
function fetchReducer(state, action) {
  switch (action.type) {
    case 'START':
      return { ...state, loading: true, error: null };
    case 'SUCCESS':
      return { data: action.payload, loading: false, error: null };
    case 'ERROR':
      return { data: null, loading: false, error: action.payload };
    default:
  // Return: { data, loading, error }
  return state;
  }
}

// Hook: useReducer per stato + asyncFn (callback) + deps + skip flag
export function useFetch(asyncFn, deps = [], skip = false) {
  // Stato iniziale: loading=!skip (se skip, parte come non in loading)
  const [state, dispatch] = useReducer(fetchReducer, {
    data: null,
    loading: !skip,
    error: null,
  });

  useEffect(() => {
    // Skip: dispatch SUCCESS null, nessuna chiamata
    if (skip) {
      dispatch({ type: 'SUCCESS', payload: null });
      return;
    }

    // Cleanup: AbortController + cancelled flag (previene dispatch su component unmounted)
    const controller = new AbortController();
    let cancelled = false;

    // START: dispatch loading=true
    dispatch({ type: 'START' });

    // Async execution: chiama asyncFn con signal, dispatch SUCCESS/ERROR
    (async () => {
      try {
        const result = await asyncFn(controller.signal);
        if (!cancelled) {
          dispatch({ type: 'SUCCESS', payload: result });
        }
      } catch (err) {
        if (!cancelled && !axios.isCancel(err)) {
          dispatch({ type: 'ERROR', payload: err });
        }
      }
    })();

    // Cleanup unmount: cancelled=true + controller.abort()
    return () => {
      cancelled = true;
      controller.abort();
    };
  }, [skip, ...deps]);

  return state;
}
