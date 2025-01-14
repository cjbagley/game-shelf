<script setup lang="ts">
import { truncateText } from '@/Helpers/truncateText';
import GameDetail from './GameDetail.vue';

defineProps({
    game: {
        type: Object,
        required: true,
    },
});
</script>

<template v-if="game">
    <dialog class="modal">
        <div class="modal-box border border-primary bg-slate-900">
            <form method="dialog">
                <button class="btn btn-circle btn-ghost btn-sm absolute right-2 top-2">✕</button>
            </form>
            <div class="grid gap-4">
                <h2 class="text-center text-lg font-semibold">{{ game.name }}</h2>

                <div v-if="game.cover?.url" class="flex w-full flex-col items-center justify-center gap-4 text-center">
                    <img
                        :src="game.cover.url.replace('thumb', 'cover_big')"
                        :alt="game.name"
                        height="200"
                        width="200"
                        class="object-cover"
                    />
                </div>

                <p v-if="game.summary">{{ truncateText(game.summary, 400) }}</p>

                <div class="flex flex-col justify-center gap-2">
                    <GameDetail label="Test" value="test" />
                    <GameDetail
                        label="Rating"
                        :value="
                            game.total_rating
                                ? `${Math.round(game.total_rating)}% (${game.total_rating_count} reviews)`
                                : '?'
                        "
                    />
                    <GameDetail
                        v-if="game.platforms?.length"
                        label="Platforms"
                        :value="game.platforms.map((p) => p.name).join(', ')"
                    />
                    <GameDetail
                        v-if="game.genres?.length"
                        label="Genres"
                        :value="game.genres.map((genre) => genre.name).join(', ')"
                    />
                    <GameDetail
                        v-if="game.first_release_date"
                        label="Release Date"
                        :value="new Date(game.first_release_date * 1000).toLocaleDateString()"
                    />
                </div>
            </div>
        </div>
    </dialog>
</template>
