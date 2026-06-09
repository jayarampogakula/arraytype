-- Admin user seed for ArrayType
SET @now = NOW();
INSERT INTO users (name, email, password, is_admin, email_verified_at, created_at, updated_at) 
VALUES ('ArrayType Admin', 'admin@arraytype.com', '$2y$12$N7n4Zy6ORFEFGLJh8MztQbateTQ8DSlF9RaYqWUvwM', 1, NOW(), NOW(), NOW());

SET @admin_id = LAST_INSERT_ID();

INSERT INTO profiles (user_id, bio, skills, created_at, updated_at)
VALUES (@admin_id, 'Platform administrator for ArrayType', 'AI, Machine Learning, Platform Management', NOW(), NOW());

INSERT INTO `groups` (name, description, created_by, created_at, updated_at) VALUES
('AI Agents', 'Community for building and deploying AI autonomous agents.', @admin_id, NOW(), NOW()),
('Prompt Engineering', 'Craft powerful prompts for ChatGPT, Claude, Gemini and more.', @admin_id, NOW(), NOW()),
('LLM Development', 'Fine-tuning, RLHF, and deploying large language models.', @admin_id, NOW(), NOW()),
('AI for Data Engineers', 'Using AI to build smarter data pipelines and analytics.', @admin_id, NOW(), NOW());

INSERT INTO group_members (group_id, user_id, role, created_at, updated_at)
SELECT id, @admin_id, 'moderator', NOW(), NOW() FROM `groups`;

INSERT INTO companies (name, website, description, user_id, created_at, updated_at)
VALUES ('OpenAI', 'https://openai.com', 'Creating safe and beneficial AI.', @admin_id, NOW(), NOW());

SET @company_id = LAST_INSERT_ID();

INSERT INTO job_listings (title, company_id, location, type, description, url, created_at, updated_at) VALUES
('Senior AI Engineer', @company_id, 'Remote / San Francisco', 'Full-time', 'Join our team to build and scale AI APIs.', 'https://openai.com/careers', NOW(), NOW()),
('Prompt Engineer', @company_id, 'Remote', 'Full-time', 'Design and optimize prompts for production AI systems.', 'https://openai.com/careers', NOW(), NOW()),
('ML Research Scientist', @company_id, 'San Francisco', 'Full-time', 'Conduct cutting-edge research on large language models.', 'https://openai.com/careers', NOW(), NOW()),
('Data Scientist - AI Safety', @company_id, 'Remote', 'Full-time', 'Work on AI safety and alignment research.', 'https://openai.com/careers', NOW(), NOW());

INSERT INTO news (title, url, source, user_id, created_at, updated_at) VALUES
('OpenAI launches GPT-4o with native image output', 'https://openai.com/blog/gpt-4o', 'OpenAI Blog', @admin_id, NOW(), NOW()),
('Google Gemini Ultra achieves new benchmarks in reasoning', 'https://deepmind.google', 'Google DeepMind', @admin_id, NOW(), NOW()),
('Anthropic releases Claude 3.5 Opus with extended context', 'https://anthropic.com/news', 'Anthropic', @admin_id, NOW(), NOW()),
('Meta releases Llama 3 with 70B parameters openly', 'https://ai.meta.com/llama', 'Meta AI', @admin_id, NOW(), NOW()),
('Microsoft integrates AI copilot into all Office products', 'https://microsoft.com/copilot', 'Microsoft Blog', @admin_id, NOW(), NOW());

INSERT INTO posts (user_id, content, type, created_at, updated_at)
VALUES (@admin_id, 'Welcome to ArrayType — Where AI Minds Connect! 🤖

This is the central hub for all things AI. Share your discoveries, prompts, code and news with fellow builders. Together we push the frontier of AI forward. 

Start by following other enthusiasts and joining communities you care about! #ArrayType #AI #MachineLearning', 'text', NOW(), NOW());
