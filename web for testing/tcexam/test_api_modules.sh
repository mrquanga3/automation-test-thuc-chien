#!/bin/bash

# Helper function to extract JSON field using grep and cut (handles both strings and numbers)
extract_json_field() {
    echo "$1" | grep -o "\"$2\":[^,}]*" | cut -d':' -f2 | tr -d ' "'
}

# TCExam REST API Test Script - Module, Topic, Question Endpoints
# Tests all 15 new endpoints with Bearer token authentication

BASE_URL="http://localhost/tcexam/admin/code/tce_api.php"
TIMESTAMP=$(date +%s)
TEST_MODULE="testmodule_${TIMESTAMP}"
TEST_TOPIC="testtopic_${TIMESTAMP}"

echo "=========================================="
echo "TCExam REST API Test Suite - New Endpoints"
echo "=========================================="
echo ""

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Step 0: Login to get Bearer token
echo -e "${BLUE}[SETUP] Logging in to get Bearer token${NC}"
echo "Request: POST api/auth.login"
echo ""

LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/auth.login" \
  -d "user_name=admin&password=1234")

TOKEN=$(extract_json_field "$LOGIN_RESPONSE" "token")

if [ -z "$TOKEN" ]; then
    echo -e "${RED}❌ FAILED: Could not get authentication token${NC}"
    echo "Response: $LOGIN_RESPONSE"
    exit 1
fi

echo -e "${GREEN}✓ Logged in successfully${NC}"
echo ""

# Test 1: Add Module
echo -e "${BLUE}[TEST 1] Adding Module${NC}"

ADD_MODULE_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/module.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "module_name=$TEST_MODULE&module_enabled=1")

MODULE_ID=$(extract_json_field "$ADD_MODULE_RESPONSE" "module_id")

if [ -z "$MODULE_ID" ]; then
    echo -e "${RED}❌ FAILED: Could not get module_id${NC}"
    echo "Response: $ADD_MODULE_RESPONSE"
    exit 1
fi

echo -e "${GREEN}✓ Module created (ID: $MODULE_ID)${NC}"
echo ""

# Test 2: Get Single Module
echo -e "${BLUE}[TEST 2] Getting Single Module${NC}"

GET_MODULE_RESPONSE=$(curl -s "$BASE_URL?route=api/module.get&module_id=$MODULE_ID" \
  -H "Authorization: Bearer $TOKEN")

MODULE_GET_STATUS=$(extract_json_field "$GET_MODULE_RESPONSE" "status")
if [ "$MODULE_GET_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Module retrieved successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not retrieve module${NC}"
    echo "Response: $GET_MODULE_RESPONSE"
fi
echo ""

# Test 3: List Modules
echo -e "${BLUE}[TEST 3] Listing Modules${NC}"

LIST_MODULE_RESPONSE=$(curl -s "$BASE_URL?route=api/module.list" \
  -H "Authorization: Bearer $TOKEN")

MODULE_LIST_STATUS=$(extract_json_field "$LIST_MODULE_RESPONSE" "status")
if [ "$MODULE_LIST_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Listed modules successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not list modules${NC}"
    echo "Response: $LIST_MODULE_RESPONSE"
fi
echo ""

# Test 4: Update Module
echo -e "${BLUE}[TEST 4] Updating Module${NC}"

UPDATE_MODULE_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/module.edit" \
  -H "Authorization: Bearer $TOKEN" \
  -d "module_id=$MODULE_ID&module_name=Updated_${TEST_MODULE}&module_enabled=1")

MODULE_UPDATE_STATUS=$(extract_json_field "$UPDATE_MODULE_RESPONSE" "status")
if [ "$MODULE_UPDATE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Module updated successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not update module${NC}"
    echo "Response: $UPDATE_MODULE_RESPONSE"
fi
echo ""

# Test 5: Add Topic
echo -e "${BLUE}[TEST 5] Adding Topic${NC}"

ADD_TOPIC_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/topic.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "module_id=$MODULE_ID&topic_name=$TEST_TOPIC&topic_description=Test topic description&topic_enabled=1")

TOPIC_ID=$(extract_json_field "$ADD_TOPIC_RESPONSE" "topic_id")

if [ -z "$TOPIC_ID" ]; then
    echo -e "${RED}❌ FAILED: Could not get subject_id${NC}"
    echo "Response: $ADD_TOPIC_RESPONSE"
    exit 1
fi

echo -e "${GREEN}✓ Topic created (ID: $TOPIC_ID)${NC}"
echo ""

# Test 6: Get Single Topic
echo -e "${BLUE}[TEST 6] Getting Single Topic${NC}"

GET_TOPIC_RESPONSE=$(curl -s "$BASE_URL?route=api/topic.get&topic_id=$TOPIC_ID" \
  -H "Authorization: Bearer $TOKEN")

TOPIC_GET_STATUS=$(extract_json_field "$GET_TOPIC_RESPONSE" "status")
if [ "$TOPIC_GET_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Topic retrieved successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not retrieve topic${NC}"
    echo "Response: $GET_TOPIC_RESPONSE"
fi
echo ""

# Test 7: List Topics by Module
echo -e "${BLUE}[TEST 7] Listing Topics by Module${NC}"

LIST_TOPIC_RESPONSE=$(curl -s "$BASE_URL?route=api/topic.list&module_id=$MODULE_ID" \
  -H "Authorization: Bearer $TOKEN")

TOPIC_LIST_STATUS=$(extract_json_field "$LIST_TOPIC_RESPONSE" "status")
if [ "$TOPIC_LIST_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Listed topics successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not list topics${NC}"
    echo "Response: $LIST_TOPIC_RESPONSE"
fi
echo ""

# Test 8: Update Topic
echo -e "${BLUE}[TEST 8] Updating Topic${NC}"

UPDATE_TOPIC_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/topic.edit" \
  -H "Authorization: Bearer $TOKEN" \
  -d "topic_id=$TOPIC_ID&topic_name=Updated_${TEST_TOPIC}&topic_description=Updated description&topic_enabled=1")

TOPIC_UPDATE_STATUS=$(extract_json_field "$UPDATE_TOPIC_RESPONSE" "status")
if [ "$TOPIC_UPDATE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Topic updated successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not update topic${NC}"
    echo "Response: $UPDATE_TOPIC_RESPONSE"
fi
echo ""

# Test 9: Add Question
echo -e "${BLUE}[TEST 9] Adding Question${NC}"

ADD_QUESTION_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/question.add" \
  -H "Authorization: Bearer $TOKEN" \
  -d "topic_id=$TOPIC_ID&question_description=Test question content&question_type=1&question_difficulty=1&question_enabled=1")

QUESTION_ID=$(extract_json_field "$ADD_QUESTION_RESPONSE" "question_id")

if [ -z "$QUESTION_ID" ]; then
    echo -e "${RED}❌ FAILED: Could not get question_id${NC}"
    echo "Response: $ADD_QUESTION_RESPONSE"
    exit 1
fi

echo -e "${GREEN}✓ Question created (ID: $QUESTION_ID)${NC}"
echo ""

# Test 10: Get Single Question
echo -e "${BLUE}[TEST 10] Getting Single Question${NC}"

GET_QUESTION_RESPONSE=$(curl -s "$BASE_URL?route=api/question.get&question_id=$QUESTION_ID" \
  -H "Authorization: Bearer $TOKEN")

QUESTION_GET_STATUS=$(extract_json_field "$GET_QUESTION_RESPONSE" "status")
if [ "$QUESTION_GET_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Question retrieved successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not retrieve question${NC}"
    echo "Response: $GET_QUESTION_RESPONSE"
fi
echo ""

# Test 11: List Questions by Topic
echo -e "${BLUE}[TEST 11] Listing Questions by Topic${NC}"

LIST_QUESTION_RESPONSE=$(curl -s "$BASE_URL?route=api/question.list&topic_id=$TOPIC_ID&page=1&limit=10" \
  -H "Authorization: Bearer $TOKEN")

QUESTION_LIST_STATUS=$(extract_json_field "$LIST_QUESTION_RESPONSE" "status")
if [ "$QUESTION_LIST_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Listed questions successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not list questions${NC}"
    echo "Response: $LIST_QUESTION_RESPONSE"
fi
echo ""

# Test 12: Update Question
echo -e "${BLUE}[TEST 12] Updating Question${NC}"

UPDATE_QUESTION_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/question.edit" \
  -H "Authorization: Bearer $TOKEN" \
  -d "question_id=$QUESTION_ID&question_description=Updated question content&question_difficulty=2&question_enabled=1")

QUESTION_UPDATE_STATUS=$(extract_json_field "$UPDATE_QUESTION_RESPONSE" "status")
if [ "$QUESTION_UPDATE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Question updated successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not update question${NC}"
    echo "Response: $UPDATE_QUESTION_RESPONSE"
fi
echo ""

# Test 13: Delete Question
echo -e "${BLUE}[TEST 13] Deleting Question${NC}"

DELETE_QUESTION_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/question.delete" \
  -H "Authorization: Bearer $TOKEN" \
  -d "question_id=$QUESTION_ID")

QUESTION_DELETE_STATUS=$(extract_json_field "$DELETE_QUESTION_RESPONSE" "status")
if [ "$QUESTION_DELETE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Question deleted successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not delete question${NC}"
    echo "Response: $DELETE_QUESTION_RESPONSE"
fi
echo ""

# Test 14: Delete Topic
echo -e "${BLUE}[TEST 14] Deleting Topic${NC}"

DELETE_TOPIC_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/topic.delete" \
  -H "Authorization: Bearer $TOKEN" \
  -d "topic_id=$TOPIC_ID")

TOPIC_DELETE_STATUS=$(extract_json_field "$DELETE_TOPIC_RESPONSE" "status")
if [ "$TOPIC_DELETE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Topic deleted successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not delete topic${NC}"
    echo "Response: $DELETE_TOPIC_RESPONSE"
fi
echo ""

# Test 15: Delete Module
echo -e "${BLUE}[TEST 15] Deleting Module${NC}"

DELETE_MODULE_RESPONSE=$(curl -s -X POST "$BASE_URL?route=api/module.delete" \
  -H "Authorization: Bearer $TOKEN" \
  -d "module_id=$MODULE_ID")

MODULE_DELETE_STATUS=$(extract_json_field "$DELETE_MODULE_RESPONSE" "status")
if [ "$MODULE_DELETE_STATUS" = "success" ]; then
    echo -e "${GREEN}✓ Module deleted successfully${NC}"
else
    echo -e "${RED}❌ FAILED: Could not delete module${NC}"
    echo "Response: $DELETE_MODULE_RESPONSE"
fi
echo ""

# Summary
echo "=========================================="
echo -e "${GREEN}✓ All tests completed!${NC}"
echo "=========================================="
echo ""
