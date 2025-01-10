import {ref} from "vue";
import axios from "axios";

export function useIgdb() {
    const loading = ref(false);
    const error = ref(null);

    const makeIgdbRequest = async (endpoint: string, query: string) => {
        loading.value = true;
        error.value = null;

        try {
            const response = await axios
                .post(`/${endpoint}`, JSON.stringify({query: query}))
                .catch((error) => {
                    return {data: null, error: error.value};
                });

            return {data: response.data, error: null};
        } catch (err) {
            return {
                data: null,
                error: err instanceof Error ? err.message : "Unknown error",
            };
        } finally {
            loading.value = false;
        }
    };

    const searchGames = async (searchTerm: string) => {
        const query = `
              search "${searchTerm}";
              fields
                name,
                cover.url,
                total_rating,
                total_rating_count,
                category,
                first_release_date,
                platforms.name,
                platforms.abbreviation,
                summary,
                genres.name;
              where category = (0) & rating != null;
              limit 100;
            `;

        // Cannot pass sort to the IGDB API when using search
        // So, sort the results by rating after receiving them
        const {data, error} = await makeIgdbRequest("search", query);

        return {data, error};
    };

    return {
        loading,
        error,
        searchGames,
    };
}
