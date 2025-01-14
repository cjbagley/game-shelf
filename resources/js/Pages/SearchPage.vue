<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref } from 'vue';
import { useIgdb } from '@/Composables/useIgdb';
import CardDisplay from '@/Components/CardDisplay.vue';
import BadgeText from '@/Components/BadgeText.vue';
import { truncateText } from '@/Helpers/truncateText';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
            <label class="input input-bordered me-5 flex inline-flex w-1/4 items-center gap-2">
                <input v-model="searchQuery" type="text" class="grow" placeholder="Search games..." />
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16"
                    fill="currentColor"
                    class="h-4 w-4 opacity-70"
                >
                    <path
                        fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd"
                    />
                </svg>
            </label>

            <PrimaryButton type="submit" :disabled="loading">
                {{ loading ? 'Searching...' : 'Search' }}
            </PrimaryButton>
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
