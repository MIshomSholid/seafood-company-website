<?php

/**
 * AI Service Configuration for PT Samudra Kencana Mina
 * Supports Google Gemini, OpenAI, Groq, or OpenAI-compatible custom endpoints.
 */

return [
    'provider' => getenv('AI_PROVIDER') ?: 'gemini',
    'api_key' => getenv('AI_API_KEY') ?: (getenv('GEMINI_API_KEY') ?: (getenv('OPENAI_API_KEY') ?: '')),
    'model' => getenv('AI_MODEL') ?: 'gemini-1.5-flash',
    'base_url' => getenv('AI_BASE_URL') ?: '',
    'temperature' => 0.5,
    'max_tokens' => 800,
    'timeout' => 15,
];