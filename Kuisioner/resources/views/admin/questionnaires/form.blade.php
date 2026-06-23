@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="border-b pb-4 mb-6">
            <h2 class="text-3xl font-bold text-gray-800">{{ $questionnaire->title }}</h2>
            <p class="text-gray-600 mt-2">{{ $questionnaire->description }}</p>
        </div>
        
        <form action="{{ route('respondent.submit', $questionnaire->id) }}" method="POST">
            @csrf
            
            @forelse($questionnaire->questions as $index => $question)
                <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                    <p class="text-lg font-semibold text-gray-800 mb-1">
                        {{ $index + 1 }}. {{ $question->question_text }}
                    </p>
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-3">
                        Target SDG: {{ $question->sdgGoal->name }}
                    </span>
                    
                    <textarea name="answers[{{ $question->id }}]" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Tulis jawaban atau tanggapan Anda di sini..."></textarea>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500">
                    Belum ada pertanyaan untuk kuesioner ini.
                </div>
            @endforelse

            @if($questionnaire->questions->count() > 0)
                <div class="mt-8 border-t pt-6">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                        Kirim Jawaban Kuesioner
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-3">Pastikan tidak ada pertanyaan wajib yang terlewat sebelum data dikirim.</p>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection