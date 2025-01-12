import { ref } from 'vue';
import axios from 'axios';

export function useIgdb() {
    const loading = ref(false);
    const error = ref(null);

    const makeIgdbRequest = async (endpoint: string, query: string) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await axios.post(`/${endpoint}`, { query: query }).catch((error) => {
                return { data: null, error: error.value };
            });

            return { data: response.data, error: null };
        } catch (err) {
            return {
                data: null,
                error: err instanceof Error ? err.message : 'Unknown error',
            };
        } finally {
            loading.value = false;
        }
    };

    const searchGames = async (searchTerm: string) => {
        const { data, error } = await makeIgdbRequest('search', searchTerm);

        return { data, error };
    };

    return {
        loading,
        error,
        searchGames,
    };
}
