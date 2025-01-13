<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';
import { useIgdb } from '@/Composables/useIgdb';
import CardDisplay from '@/Components/CardDisplay.vue';
import BadgeText from '@/Components/BadgeText.vue';
import { truncateText } from '@/Helpers/truncateText';

const { searchGames, loading, error } = useIgdb();
const searchQuery = ref('');
const games = ref([]);

const handleSearch = async () => {
    if (!searchQuery.value.trim()) return;

    const { data, error: searchError } = await searchGames(searchQuery.value);

    if (searchError) {
        games.value = [];
        return;
    }
    games.value = data;
};
</script>

<template>
    <GuestLayout>
        <Head title="Search" />
        <form @submit.prevent="handleSearch">
            <input v-model="searchQuery" type="text" placeholder="Search games..." class="rounded border p-2" />
            <button type="submit" :disabled="loading" class="ml-2 rounded bg-blue-500 px-4 py-2 text-white">
                {{ loading ? 'Searching...' : 'Search' }}
            </button>
        </form>

        <div v-if="error" class="mt-4 text-red-500">
            {{ error }}
        </div>

        <div
            v-if="games.length"
            class="mt-12 grid grid-cols-1 justify-items-center gap-y-12 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4"
        >
            <CardDisplay
                v-for="game in games"
                :key="game.id"
                :alt="game.name"
                :title="truncateText(game.name, 40)"
                :image="game?.cover?.url ? game.cover.url.replace('thumb', 'cover_big') : ''"
                additional-body-classes="justify-top text-center items-center"
            >
                <ul class="flex list-none flex-wrap items-center justify-center gap-2 align-top">
                    <li v-for="platform in game.platforms" :key="platform.id">
                        <BadgeText>
                            {{ truncateText(platform.abbreviation ? platform.abbreviation : platform.name, 10) }}
                        </BadgeText>
                    </li>
                </ul>
            </CardDisplay>
        </div>
    </GuestLayout>
</template>
