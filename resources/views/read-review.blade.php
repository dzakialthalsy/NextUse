<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review & Rating - {{ $user->name }} - NextUse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @layer utilities {
            .main-gradient {
                background: linear-gradient(to right, #14b8a6, #10b981);
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    <!-- Header -->
    @include('components.navbar')

    <main class="flex-1 py-8 px-4 sm:px-6">
        <div class="max-w-[1200px] mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold mb-2 text-gray-900">Review & Rating</h1>
                <p class="text-gray-600">Ulasan dan penilaian untuk {{ $user->name }}</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <!-- User Profile Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6 shadow-sm">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                        <div class="flex items-center space-x-4 mt-1">
                            <span class="text-sm text-gray-600">{{ $transactionCount }} transaksi</span>
                            <div class="flex items-center space-x-1">
                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                </svg>
                                <span class="text-lg text-gray-900 font-semibold">{{ $averageRating }}</span>
                                <span class="text-sm text-gray-500">({{ $totalReviews }} ulasan)</span>
                            </div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->id() != $user->id)
                        <a href="{{ route('review.create', ['user_id' => $user->id]) }}" class="bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-medium py-2 px-4 rounded-lg">
                            Beri Review
                        </a>
                    @endif
                </div>

                <!-- Rating Distribution -->
                @if($totalReviews > 0)
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Distribusi Rating</h3>
                        <div class="space-y-2">
                            @for($i = 5; $i >= 1; $i--)
                                @php
                                    $count = $ratingDistribution->get($i) ? $ratingDistribution->get($i)->count : 0;
                                    $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                @endphp
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600 w-8">{{ $i }} ⭐</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-12 text-right">{{ $count }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endif
            </div>

            <!-- Reviews List -->
            <div class="space-y-4">
                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        @if($review->show_name && $review->reviewer)
                                            <span class="text-gray-600 font-medium text-sm">{{ substr($review->reviewer->name, 0, 1) }}</span>
                                        @else
                                            <span class="text-gray-600 font-medium text-sm">A</span>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">
                                            @if($review->show_name && $review->reviewer)
                                                {{ $review->reviewer->name }}
                                            @else
                                                Anonim
                                            @endif
                                        </h3>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($review->title)
                                <h4 class="font-medium text-gray-900 mb-2">{{ $review->title }}</h4>
                            @endif

                            <p class="text-gray-700 mb-4 whitespace-pre-wrap">{{ $review->review_text }}</p>

                            @if($review->images && count($review->images) > 0)
                                <div class="grid grid-cols-3 gap-3 mb-4">
                                    @foreach($review->images as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Review image" class="w-full h-32 object-cover rounded-lg border border-gray-200 cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="bg-white border border-gray-200 rounded-lg p-12 text-center shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Review</h3>
                        <p class="text-gray-600 mb-4">Pengguna ini belum memiliki review.</p>
                        @if(auth()->check() && auth()->id() != $user->id)
                            <a href="{{ route('review.create', ['user_id' => $user->id]) }}" class="inline-flex items-center bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-medium py-2 px-4 rounded-lg">
                                Beri Review Pertama
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="closeImageModal()">
        <div class="max-w-4xl mx-4">
            <img id="modalImage" src="" alt="Review image" class="max-w-full max-h-screen rounded-lg">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('imageModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('imageModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</body>
</html>

