import { useReducer, useEffect } from 'react';

const initialState = { data: null, loading: true, error: null };

function fetchReducer(state, action) {
  switch (action.type) {
    case 'START':
      return { ...state, loading: true, error: null };
    case 'SUCCESS':
      return { data: action.payload, loading: false, error: null };
    case 'ERROR':
      return { data: null, loading: false, error: action.payload };
    default:
      return state;
  }
}

export function useFetch(asyncFn, deps = [], skip = false) {
  const [state, dispatch] = useReducer(fetchReducer, {
    data: null,
    loading: !skip,
    error: null,
  });

  useEffect(() => {
    if (skip) {
      dispatch({ type: 'SUCCESS', payload: null });
      return;
    }

    const controller = new AbortController();
    let cancelled = false;

    dispatch({ type: 'START' });

    (async () => {
      try {
        const result = await asyncFn(controller.signal);
        if (!cancelled) {
          dispatch({ type: 'SUCCESS', payload: result });
        }
      } catch (err) {
        if (!cancelled && err?.name !== 'CanceledError') {
          dispatch({ type: 'ERROR', payload: err });
        }
      }
    })();

    return () => {
      cancelled = true;
      controller.abort();
    };
  }, [skip, ...deps]);

  return state;
}
